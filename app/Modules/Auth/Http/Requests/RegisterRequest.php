<?php

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:30', Rule::unique('users', 'username')],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
