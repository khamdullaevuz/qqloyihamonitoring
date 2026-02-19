<?php

namespace App\Filters;

use App\Filters\BaseFilter;
use App\Interfaces\Searchable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @psalm-api
 */
class DistrictFilter extends BaseFilter implements Searchable
{
    public const string REGION_ID = 'region_id';

    public function __construct(array $queryParams)
    {
        parent::__construct($queryParams);
    }

    protected function getCallback(): array
    {
        return [
            self::REGION_ID => [$this, 'regionId'],
            self::LIMIT     => [$this, 'limit'],
            self::SEARCH    => [$this, 'search'],
            self::SORT      => [$this, 'sort'],
        ];
    }

    public function regionId(Builder $builder, string $value): void
    {
        $builder->where('region_id', $value);
    }

    public function searchFields(string $search): array
    {
        return [
        ];
    }

    public function sortFields(): array
    {
        return [
        ];
    }
}
