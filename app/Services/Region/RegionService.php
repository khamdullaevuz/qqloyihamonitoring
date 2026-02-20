<?php

namespace App\Services\Region;

use App\Filters\RegionFilter;
use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

class RegionService
{
    public function list(array $data): Collection
    {
        $query = Region::query();

        $filter = app()->make(RegionFilter::class, ['queryParams' => $data]);

        $query->filter($filter);

        return $query->get();
    }
}
