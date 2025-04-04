<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationSendRequest extends FormRequest
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
            'online_external_id' => 'required|string|exists:users,external_id',
            'external_ids' => 'array',
            'external_ids.*' => 'required|string|exists:users,external_id',
            'title' => 'required|string|between:1,255',
            'message' => 'required|string|between:1,500',
        ];
    }
}
