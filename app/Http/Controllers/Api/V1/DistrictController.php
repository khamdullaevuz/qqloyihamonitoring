<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\DistrictFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RegionResource;
use App\Models\District;
use App\Models\Permission;
use App\Models\Region;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = District::query();

        $filter = app()->make(DistrictFilter::class, ['queryParams' => $request->all()]);
        $query->filter($filter);

        return DistrictResource::collection($query->get());
    }
}
