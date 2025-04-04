<?php

namespace App\Http\Requests;

use App\Settings\GameSetting;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'external_id' => 'required|string|max:255',
            'age' => 'required|integer|between:1,100',
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'profile_image' => 'nullable|string',
            'firebase_id' => 'nullable|string|max:255',
        ];
    }

    public function prepareForValidation(): void
    {
        $gameSetting = new GameSetting;
        $this->merge([
            'gems' => $gameSetting->gems,
            'coins' => $gameSetting->coins,
        ]);
    }
}
