<?php

namespace App\Filters;

use App\Filters\BaseFilter;
use App\Interfaces\Searchable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @psalm-api
 */
class RegionFilter extends BaseFilter implements Searchable
{
    public const string NAME = 'name';

    protected function getCallback(): array
    {
        return [
            self::LIMIT  => [$this, 'limit'],
            self::SEARCH => [$this, 'search'],
            self::SORT   => [$this, 'sort'],
        ];
    }

    public function searchFields(string $search): array
    {
        return [
            self::NAME => self::NAME,
        ];
    }

    public function sortFields(): array
    {
        return [
            self::NAME => self::NAME,
        ];
    }
}
