<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\Role\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(public RoleService $service) { }

    public function index(Request $request)
    {
        $roles = $this->service->all($request->all());

        return RoleResource::collection($roles);
    }

    public function store(RoleRequest $request)
    {
        $this->service->create($request->toDto());

        return response()->noContent();
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->service->update($role, $request->toDto());

        return response()->noContent();
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json();
    }
}
