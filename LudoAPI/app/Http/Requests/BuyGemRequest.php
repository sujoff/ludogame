<?php

namespace App\Http\Requests;

use App\Enums\CurrencyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class BuyGemRequest extends FormRequest
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
            'gem' => 'required|integer|min:1',
            'external_id' => 'nullable|string|exists:users,external_id',
            'external_txn_id' => 'required|string|min:1',
            'amount'  => 'required|numeric|min:0.00',
            'currency_type' => 'required|string|in:'.implode(',',CurrencyTypeEnum::values()),
        ];
    }
}
