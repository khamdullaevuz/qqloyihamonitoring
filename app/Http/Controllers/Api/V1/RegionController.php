<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RegionResource;
use App\Models\Permission;
use App\Models\Region;
use App\Services\Region\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(public RegionService $service) { }

    public function index(Request $request)
    {
        $data = $this->service->list($request->all());
        return RegionResource::collection($data);
    }
}
