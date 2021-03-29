<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            // the name is required and max length is 100 and must be string
            'name'=>'required|max:100|string',

            /* the logo is required except the form have input with name id 
            the logo must be mimes with extension jpg,jpeg and png*/
            'logo'=>'required_without:id|mimes:jpg,jpeg,png',

            /* the phone must be required and max length is 100 and unique in table
            vendor in column phone  */
            'phone'=>'required|max:11|unique:vendors,phone,'.$this->id,

            /* the email must be required and valid email and unique in table
            vendor in column phone  */
            'email'=>'required|email|unique:vendors,email,'.$this->id,

            /* the category_id required and must be exists in table main_categories in
            coumn id */
            'category_id'=>'required|exists:main_categories,id',

            //the password is required except the form have input with name id
            'password'=>'required_without:id',

            // the address is required and string and max length is 500
            // 'address'   => 'required|string|max:500',
        ];
    }

    public function messanges(){
        return [
            // the required message
            'required'=>'هذا الحقل مطلوب',
            
            // the logo required message
            'logo.required_without'=>'لوجو المتجر مطلوب',

            // the category_id exists message
            'category_id.exists'=>'هذا القسم غير موجود',

            // the name max length message
            'name.max'=>'اقصى قيمة 100 حرف',

            // the phone max length message
            'phone.max'=>'الرقم المطلوب 11 رقم',

            // the valid email message
            'email.email'=>'برجاء ادخال عنوان بريد الكترونى صحيح',

            // the email is string message
            'name.string'=>'الاسم يجب ان يتكون من حروف',

            // the email is address message
            'address.string' => 'العنوان لابد ان يكون حروف او حروف وارقام ',

            // the phone is unique message
            'phone.unique'=>'هذا الرقم موجود مسبقا',

            // the email is unique message
            'email.unique'=>'هذا البريد الإلكترونى موجود مسبقا '
        ];
    }
}
