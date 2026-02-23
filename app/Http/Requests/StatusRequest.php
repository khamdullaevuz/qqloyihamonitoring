<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'name'      => ['required'],
                'is_active' => ['boolean'],
                's_code'    => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
