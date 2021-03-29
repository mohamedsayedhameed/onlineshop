<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // the email is required and max length is 100
            'email'=>'required|max:100',

            // the password is  required and max length is 100
            'password'=>'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            // email required message
            'email.required'=> 'يرجى ادخال اسم المستخدم',

            // password required message
            'password.required'=> 'يرجى اخال كلمة السر',
        ];
    }
}
