<?php

namespace App\Http\Requests\Role;

use App\DTO\RoleDto;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'name'   => ['required'],
                's_code' => ['nullable'],
                'permissions' => ['nullable', 'array'],
                'permissions.*' => ['uuid', 'exists:permissions,id'],
        ];
    }

    public function toDto(): RoleDto
    {
        return new RoleDto(
            name: $this->input('name'),
            s_code: $this->input('s_code'),
            permissions: $this->input('permissions', []),
        );
    }
}
