<?php

namespace App\Services\Role;

use App\DTO\RoleDto;
use App\Models\Role;

class RoleService
{
    public function all(array $data)
    {
        return Role::query()->paginate();
    }

    public function create(RoleDto $dto)
    {
        $role = Role::create($dto->toArray());
        $role->permissions()->sync($dto->permissions);
    }

    public function update(Role $role, RoleDto $dto): Role
    {
        $role->update($dto->toArray());

        $role->permissions()->sync($dto->permissions);
    }
}
