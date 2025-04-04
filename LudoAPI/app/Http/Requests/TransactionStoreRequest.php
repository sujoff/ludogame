<?php

namespace App\Http\Requests;

use App\Enums\CurrencyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
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
            'external_id' => 'required|string|exists:users,external_id',
            'code'  => 'required|string|exists:collections,code',
            'amount'  => 'required|numeric|min:0.00',
            'currency_type' => 'required|string|in:'.implode(',',CurrencyTypeEnum::values()),
        ];
    }
}
