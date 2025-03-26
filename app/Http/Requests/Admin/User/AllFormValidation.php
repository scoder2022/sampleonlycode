<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class FormValidation extends FormRequest
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
        if(request()->has('id') && url()->previous() == route('admin.users.edit',request()->get('id'))){
            $validates  = [
            'first_name' => 'nullable|min:2|max:50',
            'last_name' => 'nullable|min:2|max:50',
            'username' => 'required|max:60|unique:users,username,'.$this->request->get('id'),
            'email'=>'required|email|max:200|unique:users,email,'.$this->request->get('id'),
            'password'=>'sometimes|confirmed',
            'roles'=>'required|array',
            'roles.*.id' => 'exists:roles,id',
            'image'=>'sometimes|image|max:2100',
            'status'=>'sometimes|boolean'
            ];
        }else{
            $validates  = [
                'email' => 'image',
                'username' => 'required|max:60|unique:users',
                'email' => 'required|email|unique:users',
                'password'=>'required|confirmed',
                'roles'=>'required|array',
                'roles.*.id' => 'exists:roles,id',
                'image'=>'sometimes|image|max:2100',
                'status'=>'sometimes|boolean'
            ];
        }
        return $validates;
    }
}
