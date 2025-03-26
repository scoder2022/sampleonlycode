<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public $base_route = 'admin.users';
    public $panel = 'Users';
    public $folder_name = 'Users';
    public $images_path;

    public function store(Request $request)
    {
        $model = User::create(array_merge($request->validated(),$this->commonData($request)));
        //spatie role
        $model->assignRole($request->roles);
        $model->roles()->sync($request->roles);
        return $model;
    }

    public function update(Request $request, User $model): User
    {
        $model->update(array_merge($request->validated(),$this->commonData($request,$model)));
        $model->roles()->sync($request->roles);
        //spatie role
        DB::table('model_has_roles')->where('model_id',$model->id)->delete();
        $model->assignRole($request->input('roles'));
        return $model;
    }

    private function commonData($request,$model=null){
        if($request->hasFile('image')){
            $file_name = files_uploads($request->image,$this->folder_name,$model != null ? $model->image:null);
        }

        $data = [
            'full_name'=>$request->full_name,
            'image'=>isset($file_name) ? $file_name : null,
            'bio'=>$request->bio,
            'password'=>$request->filled('password') ? Hash::make($request->password): $model->password,
            'status'=>$request->has('status')
        ];

        if($model){
            array_merge($data,[
                'image'=>isset($file_name) ? $file_name : $model->image
            ]);
        }
        return $data;
    }
}
