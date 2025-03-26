<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagesValidations extends FormRequest
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
        if(request()->get('id')){
            $validates  = [
                'name'=>'required',
                'slug'=>'nullable|unique:pages,slug'.request()->get('id'),
                'image'=>'nullable|image|mimes:jpg,jpeg,png,ico,bmp'
            ];
        }

        $validates  = [
            'name'=>'required',
            'slug'=>'nullable|unique:pages,slug',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,ico,bmp'
        ];

        return $validates;
    }
}
