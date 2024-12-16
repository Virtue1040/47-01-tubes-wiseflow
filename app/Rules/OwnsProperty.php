<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use \App\Models\Property;

class OwnsProperty implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userOwnsProperty = Property::where('id_property', $value)
            ->where('id_user_owner', Auth::user()->id_user)
            ->exists();

        if (!$userOwnsProperty) {
            session()->flash('alert', [
                'type' => 'error',
                'message' => 'You dont own this property!',
            ]);
            $fail('You do not own this property.');
        }
    }

}
