<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'name'   => ['required'],
                's_code' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
