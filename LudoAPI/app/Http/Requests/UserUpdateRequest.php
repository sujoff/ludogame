<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'string',
//            'email' => ['email', 'unique:users,email,' . $this->id],
            'firebase_id' => 'string',
            'settings' => 'array',
            'statistics' => 'array',
            'coins' => 'integer',
            'gems' => 'integer',
            'gender' => 'string',
            'profile_image' => 'string',
            'skin_settings' => 'array',
            'xp' => 'integer',
        ];
    }
}
