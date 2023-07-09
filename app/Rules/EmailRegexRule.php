<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailRegexRule implements Rule
{
    protected $pattern;
    protected $errorMsg;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pattern = '/(.+)@(.+)\.(.+)/i';
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
        if (empty($value)) {
            return true;
        }

        if(!preg_match($this->pattern, $value)){
            $this->errorMsg = 'Please enter a valid :attribute';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMsg;
    }
}
