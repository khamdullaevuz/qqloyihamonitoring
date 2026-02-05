<?php

namespace App\Http\Requests\User;

use App\DTO\UserDto;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8',
        ];
    }

    public function toDto(): UserDto
    {
        return new UserDto(
            name: $this->input('name'),
            phone: $this->input('phone'),
            password: $this->input('password'),
        );
    }
}
