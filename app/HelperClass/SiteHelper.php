<?php
namespace App\HelperClass;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteHelper{

    public function test(){
        dd('here');
    }

    public function files_uploads($file,$folder_name,$oldfile=null)
    {
        //file_put_contents($path,$decode);
            // Image::make($request->file('images')->getpathname())->resize(320)->
            // save($this->folder_path.DIRECTORY_SEPARATOR.$file_names);

            if(!Storage::has($folder_name)){
               Storage::makeDirectory($folder_name);
            }
            if ($oldfile !=null && Storage::exists($oldfile)){
                Storage::delete($oldfile);
            }
            $file_names = $file->storeAs($folder_name,$folder_name.'_'.rand(0, 9999).$file->getClientOriginalName());
            return $file_names;
    }

    public function checked_values($action,$field,$target,$now,$data=false){
       if($data){
           if($now == $target){
            if($action = 'selected'){
                return 'selected="selected"';
            }elseif($action == 'check'){
                return 'checked="checked"';
            }
           }
           return false;
       }else{
           if(old($field) == $now){
            if($action = 'selected'){
                return 'selected="selected"';
            }
           }
           return false;
       }
    }

    public function usersRoleIds(User $user){
        $roles = $user->roles;
        $arr = [];
        foreach ($roles as $role){
            $arr[] = $role->id;
        }
        return $arr;
    }


    public function getOrderByParam($param)
    {
        if ($param == 'column') {
                switch (request()->get('sortBy')) {
                    case 'latest':
                        return 'created_at';
                        break;

                        case 'first_name':
                            return 'first_name';
                            break;

                        case 'email':
                            return 'email';
                            break;
                        default:
                        return 'id';
                }

        } elseif ($param == 'sort') {

            switch (request()->get('sorting')) {

                case 'asc':
                    return 'asc';
                    break;
                case 'desc':
                    return 'desc';
                    break;
                default:
                    return 'desc';

            }

        } else {
            abort(500);
        }
    }

    public function check_role($current_role)
    {
        if(auth()->check()){
            foreach (auth()->user()->roles as $role) {
                if(in_array($current_role,[$role->key])){
                    return true;
                }
            }
            return false;
        }
    }

    public function check_guard($guard){
        if($guard == 'admin'){
           return Auth::guard($guard)->check() ? true : false;
        }elseif ($guard == 'web') {
           return Auth::guard($guard)->check() ? true : false;
        }else{
            return false;
        }
    }

    public function check_guard_login(){
        if(Auth::guard('admin')->check()){
           return "admin";
        }else if(Auth::guard('web')->check()) {
           return "web";
        }else{
            return false;
        }
    }
 // 	 $f = Product::find(2);
    // $dr = $f->expiry_year.'-'.$f->expiry_month.'-1 00:01:01';
    // $fr=\Carbon\Carbon::parse($dr)
    //   ->diff(\Carbon\Carbon::parse(\Carbon\Carbon::now()))
    //   ->format('%y years, %m months %d days');
    //   $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s') );
    //   $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dr);
    //   $diff_in_days = $to->diffInDays($from);
    public function get_guard(){
        if(Auth::guard('admin')->check()){
            return "admin";
        }elseif(Auth::guard('web')->check()){
            return "web";
        }else{
            return false;
        }
    }


}
