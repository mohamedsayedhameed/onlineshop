<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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

            // the name is required and string and max length is 100
            'name'=>'required|string|max:100',

            // the abbr is required and max length is 100
            'abbr'=>'required|max:10',

            // the active is required and must be in 0 or 1
            //'active'=>'required|in:0,1',

            // the direction is required and must be in 'rtl' or 'ltr'
            'direction'=>'required|in:rtl,ltr',
        ];
    }

    public function messages()
    {
        return [
            // the required message
            'required'=> 'هذا الحقل مطلوب',

            // the in message
            'in'=> 'القيمه المدخلة غير صحيحة',

            //the name must be string message
            'name.string'=>'اسم اللغة لابد ان يكون حروف',

            // the name max length message
            'name.max'=>'اسم اللغة يجب ان لا يتجاوز 100 حرف',

            // the abbr message
            'abbr'=>'اختصار اللغة يجب ان لا يتجاوز 10 حرف',
        ];
    }
}
