<?php

namespace App\Http\Requests;

use App\Enums\CurrencyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class BuyCoinRequest extends FormRequest
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
            'coin' => 'required|integer|min:1',
            'external_id' => 'required|string|exists:users,external_id',
            'external_txn_id' => 'nullable|string|min:1',
            'amount'  => 'required|numeric|min:0.00',
            'currency_type' => 'required|string|in:'.implode(',',CurrencyTypeEnum::values()),
            'code'  => 'required|string|exists:collections,code',
        ];
    }
}
