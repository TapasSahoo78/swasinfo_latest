<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BranchWiseUserRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value >= 1990 && $value <= date('Y');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be between 1990 to ' . date('Y') . '.';
    }
}
