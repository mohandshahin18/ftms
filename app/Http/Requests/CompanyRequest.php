<?php

namespace App\Http\Requests;

use App\Rules\TextLength;
use App\Rules\TwoSyllables;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' =>['required', new TwoSyllables()],
            'email' => ['required', 'unique:companies,email'],
            'phone' => ['required', 'unique:companies,phone'],
            'address' => ['required'],
            'category_id' => ['required'],
            'password' => [$rule],
            'image' => [$rule,'image','mimes:png,jpg,jpeg,svg,jfif,webp','max:2048'],
            'description' => ['required', new TextLength()],
            'role_id' => $rule,
        ];
    }
}
