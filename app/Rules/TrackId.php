<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TrackId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
     
    protected  $trackID;
    public function __construct($trackID)
    {
        //
        $this->trackID=$trackID;
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
        //
        if($this->trackID != null){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'check category  is required';
    }
}
