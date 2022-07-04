<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FromTimeToTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $fromto; 
    protected $error; 
    public function __construct(array $fromTO)
    {
        $this->fromto=$fromTO;
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
        if(empty($this->fromto[0]) || empty($this->fromto[1])){
            
            $this->error="From Time Or  To Time Can't Be Empty";
            return 0;
        }elseif($this->fromto[0] > $this->fromto[1]){
            
            $this->error="From Time Can't greater than To Time ";
            return 0;
            
        
            
        }else{
            return 1;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error ;
    }
}
