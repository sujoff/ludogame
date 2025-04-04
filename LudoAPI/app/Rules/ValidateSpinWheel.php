<?php

namespace App\Rules;

use App\Models\User;
use App\Models\UserSpinWheel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateSpinWheel implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('external_id', $value)->first();

        $userSpinWheel = UserSpinWheel::where('user_id', $user->id)->whereDate('created_at',today())->first();

        if ($userSpinWheel) {
            $fail('Not allowed to perform spin wheel request');
        }

    }
}
