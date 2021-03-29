<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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

            /* the photo is required except the form has input name id
            the photo must be mimes with extension jpg,jpeg and png */
            'photo' => 'required_without:id|mimes:jpg,jpeg,png',

            // the category is required and array with minimum one element
            'category' => 'required|array|min:1',

            // the name in category is required
            'category.*.name' => 'required',

            // the abbr in category is required
            'category.*.abbr' => 'required',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
