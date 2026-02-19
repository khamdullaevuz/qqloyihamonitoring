<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

/**
 * @psalm-api
 */
interface FilterInterface
{
    public function apply(Builder $builder): void;
}
