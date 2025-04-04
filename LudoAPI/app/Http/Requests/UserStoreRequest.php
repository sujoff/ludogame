<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'password'],
            'email_verified_at' => ['nullable', 'date'],
            'remember_token' => ['nullable', 'string', 'max:100'],
        ];
    }
}
