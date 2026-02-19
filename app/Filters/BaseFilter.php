<?php

namespace App\Filters;

use App\Interfaces\FilterInterface;
use App\Interfaces\Searchable;
use Closure;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @psalm-api
 */
abstract class BaseFilter implements FilterInterface
{
    public const string CREATED_AT           = 'created_at';
    public const string UPDATED_AT           = 'updated_at';
    public const string SORT                 = 'sort';
    public const string LIMIT                = 'limit';
    public const string ONLY_DELETED         = 'only_deleted';
    public const string WITH_DELETED         = 'with_deleted';
    public const string ORGANISATION_S_CODE  = 'organisation_s_code';
    public const string ACCESS_ORGANISATIONS = 'accessOrganisations';

    public array $organisations = [];
    /**
     * @var array
     */
    private array $queryParams;

    /**
     * @param array $queryParams
     *
     * @psalm-api
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    public function apply(Builder $builder): void
    {
        $this->before($builder);

        foreach ($this->getCallback() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }

        $builder->whereNot(function (Builder $query) {
            foreach ($this->getReverseCallback() as $name => $callback) {
                if (isset($this->queryParams[$name])) {
                    call_user_func($callback, $query, $this->queryParams[$name]);
                }
            }
        });

        $this->after($builder);
    }

    /**
     * @param Builder $builder
     * @param array $queryParams
     *
     * @psalm-suppress PossiblyUnusedParam
     *
     * @return void
     */
    protected function before(Builder $builder): void
    {
    }

    abstract protected function getCallback(): array;

    protected function getReverseCallback(): array
    {
        return [];
    }

    /**
     * @param Builder $builder
     * @param array $queryParams
     *
     * @psalm-suppress PossiblyUnusedParam
     *
     * @return void
     */
    protected function after(Builder $builder): void
    {
    }

    public function getAllQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getQueryParams(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function withDeleted(Builder $builder, bool $value = false): void
    {
        $builder->withDeleted($value);
    }

    public function onlyDeleted(Builder $builder, bool $value): void
    {
        $builder->onlyDeleted($value);
    }

    public function limit(Builder $builder, int $value): void
    {
        $builder->limit($value);
    }

    public function search(Builder $builder, array $value): void
    {
        $builder->when($this instanceof Searchable,
            function (Builder $query) use ($value) {
                $searchType = (string)$this->getQueryParams(Searchable::SEARCH_TYPE, 'OR');
                $whereLike  = $searchType === 'and' ? 'where' : 'orWhere';
                $query->where(function (Builder $q) use ($value, $whereLike, $searchType) {
                    foreach ($value as $key => $search) {
                        if(!isset($search))
                        {
                            continue;
                        }
                        if (!is_array($search))
                        {
                            $search = trim($search);
                        }
                        $field  = $this->getSearchField($key, $search);
                        $q->when(is_callable($field),
                            function (Builder $q) use ($field, $searchType) {
                                $q->where(column: $field,
                                    boolean:      $searchType);
                            }, function (Builder $q) use ($field, $search, $whereLike) {
                                if(is_array($search)) {
                                    $whereIn = $whereLike === 'orWhere' ? 'orWhereIn' : 'whereIn';
                                    $q->{$whereIn}($field, \Arr::wrap($search));
                                }else{
                                    $q->{$whereLike}($field, 'ilike', "%$search%");
                                }
                            });
                    }
                });
            });
    }

    /**
     * @param string $key
     * @param string $search
     *
     * @psalm-suppress UndefinedMethod
     *
     * @return mixed
     * @throws \Exception
     */
    private function getSearchField(string $key, string|array $search): mixed
    {
        $searchFields = $this->searchFields($search) + $this->searchFieldsDefault($search);

        return $searchFields[$key] ?? throw new \Exception(__('messages.field_does_not_exists', ['field' => $key]));
    }

    private function searchFieldsDefault(string|array $search): array
    {
        return [
            'created_by.name'   => function (Builder $builder) use ($search) {
                $builder->whereHas('createdBy', function (Builder $query) use ($search) {
                    $query->whereLike([DB::raw("concat(first_name, ' ', last_name)")], $search);
                });
            },
            'updated_by.name'   => function (Builder $builder) use ($search) {
                $builder->whereHas('updatedBy', function (Builder $q) use ($search) {
                    $q->whereLike([DB::raw("concat(first_name, ' ', last_name)")], $search);
                });
            },
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',
        ];
    }

    public function sort(Builder $builder, string $value): void
    {
        foreach (explode(',', $value) as $column) {
            $direction = Str::startsWith($column, '-') ? 'desc' : 'asc';
            $column    = Str::startsWith($column, '-') ? Str::after($column, '-') : $column;
            $sortField = $this->getSortField($column);

            if ($sortField instanceof Closure) {
                // If the sort field is a callable, execute it
                $sortField($builder, $column, $direction);
            } else {
                // Otherwise, apply the orderBy to the builder
                $builder->orderBy($sortField, $direction);
            }
        }
    }

    private function getSortField(string $column): mixed
    {
        $searchFields = $this->sortFields() + $this->sortFieldsDefault();

        return $searchFields[$column] ?? throw new \Exception(__('messages.field_does_not_exists', ['field' => $column]));
    }

    abstract protected function sortFields(): array;

    private function sortFieldsDefault(): array
    {
        return [
            'created_by.name'   => function (Builder $builder, string $column, string $direction) {
                $builder->whereHas('createdBy', function (Builder $builder) use ($direction) {
                    $builder->orderBy(DB::raw("concat(first_name,' ',last_name)"), $direction);
                });
            },
            'updated_by.name'   => function (Builder $builder, string $column, string $direction) {
                $builder->whereHas('updatedBy', function (Builder $builder) use ($direction) {
                    $builder->orderBy(DB::raw("concat(first_name,' ',last_name)"), $direction);
                });
            },
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',
        ];
    }

    /**
     * @param string $key
     *
     * @return bool
     * @psalm-suppress UndefinedMethod
     */
    public function hasKeyParams(string $key): bool
    {
        return array_key_exists($key, $this->queryParams);
    }

    /**
     * @param string[] $keys
     *
     * @psalm-suppress UndefinedMethod
     */
    public function hasAnyKeyParams(string ...$keys): bool
    {
        foreach ($keys as $key) {
            if ($this->hasKeyParams($key)) {
                return true;
            }
        }

        return false;
    }
}
