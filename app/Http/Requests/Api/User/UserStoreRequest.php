<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
                'password'=>'required|confirmed',
                'roles'=>'required|array',
                'roles.*.id' => 'exists:roles,id',
                'image'=>'sometimes|image|max:2100',
                'status'=>'sometimes|boolean'
        ];
    }
}
