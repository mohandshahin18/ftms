<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
        $rule = 'required';

        if($this->method() == 'PUT') {
            $rule = 'nullable';
        }

        return [
            'name' => ['required','min:3','string'],
            'email' => ['required' , 'email', 'unique:teachers,email'],
            'phone' => ['required' , 'min:10' , 'max:20', 'unique:teachers,phone'],
            'password' => ['required'],
            'university_id' => ['required'],
            'specialization_id' => ['required'],
            'image' => [$rule, 'mimes:png,jpg,jpeg,webp,jfif,svg', 'max:2048'],

        ];
    }
}
