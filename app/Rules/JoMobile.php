<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class JoMobile implements Rule
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
        $pattern = "/^(?:(?:(?:\+962|0)7(?:7|8|9))|(?:06))[0-9]{7}$/";
        return (bool)preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute isn\'t valid';
    }
}
