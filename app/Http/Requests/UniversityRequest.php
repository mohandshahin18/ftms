<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $Eamilrule = 'unique:universities,email';
        $Phonerule = 'unique:universities,phone';

        if($this->method() == 'PUT') {
            $Eamilrule = '';
            $Phonerule = '';
        }

        return [
            'name' => ['required','min:3','string'],
            'email' => ['required', $Eamilrule],
            'phone' => ['required', $Phonerule],
            'address' => ['required'],
        ];
    }
}
