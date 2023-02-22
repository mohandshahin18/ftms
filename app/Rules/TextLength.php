<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TextLength implements Rule
{

    protected $len;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($len = 10)
    {
        $this->len = $len;
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
        return str_word_count(strip_tags($value)) >= $this->len;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('admin.The :attribute must be more than 10 words');
    }
}
