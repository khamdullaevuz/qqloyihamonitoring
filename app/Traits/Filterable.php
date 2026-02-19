<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\FilterInterface;

/**
 * @psalm-api
 */
trait Filterable
{
    /**
     * @param Builder $builder
     * @param FilterInterface $filter
     *
     * @psalm-api
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, FilterInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
