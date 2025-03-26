<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|max:60|unique:users,username,'.$this->request->get('id'),
            'email'=>'required|email|max:200|unique:users,email,'.$this->request->get('id'),
            'password'=>'sometimes|confirmed',
            'min:10',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character',
            'roles'=>'required|array',
            'roles.*.id' => 'exists:roles,id',
            'image'=>'sometimes|image|max:2100',
            'bio'=>'required',
            'gender'=>'required|in:male,female,others',
            'status'=>'sometimes|boolean'
            ];
    }
}
