<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRequest extends FormRequest
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

        return [
            'name' => ['required', 'min:2'],
            'email' => ['required'],
            'password' => ['required'],
            'phone' => ['required', 'min:7'],
            'image' => ['required', 'mimes:png,jpg,jpeg,webp,jfif,svg', 'max:2048'],
        ];
    }
}
