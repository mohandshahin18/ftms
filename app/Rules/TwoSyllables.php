<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwoSyllables implements Rule
{


    protected $len;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($len = 2)
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
        $arabic_word_count = preg_match_all('/\p{Arabic}+/u', $value, $arabic_matches);
        $english_word_count = preg_match_all('/\b[A-Za-z]+\b/', $value, $english_matches);



        if (preg_match('/\p{Arabic}/u', $value)) {
            // The input text is in Arabic
            return $arabic_word_count == $this->len;
        } elseif (preg_match('/[A-Za-z]/', $value)) {
            // The input text is in English
            return $english_word_count == $this->len;
        } else {
            // The input text does not contain any Arabic or English characters
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('admin.The :attribute must consist of two syllables.');
    }
}
