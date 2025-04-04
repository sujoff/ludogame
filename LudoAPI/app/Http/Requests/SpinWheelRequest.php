<?php

namespace App\Http\Requests;

use App\Rules\ValidateSpinWheel;
use Illuminate\Foundation\Http\FormRequest;

class SpinWheelRequest extends FormRequest
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
            'external_id' => [
                'required',
                'string',
                'exists:users,external_id',
            ],
            'from_ad' => [
                'required',
                'bool'
            ],
            'is_free' => [
                'nullable',
                'bool'
            ],
            'is_try_again' => [
                'nullable',
                'bool'
            ],
        ];
    }
}
