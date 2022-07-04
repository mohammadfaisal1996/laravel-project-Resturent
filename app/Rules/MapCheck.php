<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MapCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        return !((empty($value['lat']) || empty($value['lng'])) ||
            ((!is_numeric($value['lat']) || !is_numeric($value['lng'])))||
            ($value['lat'] < 0 || $value['lng'] < 0));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be marked on the map';
    }
}
