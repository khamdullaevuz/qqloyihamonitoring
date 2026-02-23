<?php

namespace App\Services\User;

use App\DTO\UserDto;
use App\Models\User;

class UserService
{
    public function all(array $data)
    {
        return User::query()->paginate();
    }

    public function create(UserDto $dto)
    {
        $user = User::create($dto->toArray());

        $user->roles()->sync($dto->roles);
    }

    public function update(User $user, UserDto $dto)
    {
        $user->update($dto->toArray());

        $user->roles()->sync($dto->roles);

        return $user;
    }
}
