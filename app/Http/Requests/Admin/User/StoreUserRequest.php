<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
                'username' => 'required|max:60|unique:users',
                'email' => 'required|email|unique:users',
                'password'=>'required|confirmed|string',
                'min:10',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character',
                'roles'=>'required|array',
                'roles.*.id' => 'exists:roles,id',
                'image'=>'sometimes|image|max:2100',
                'bio'=>'required',
                'status'=>'sometimes|boolean'
            ];
    }

    public function messages()
    {
        return [
            'password' => [
                'required' => 'Please Provide A Password!',
                'regex' => 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character!',
            ],
        ];
    }

}
