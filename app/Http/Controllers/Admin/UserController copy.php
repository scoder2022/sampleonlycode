<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public $base_route = 'admin.users';
    public $folder_path;
    public $folder;
    public $panel = 'Users';
    public $folder_name = 'Users';
    public $images_path;

    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function getUsers(Request $request)
    {
        $model = User::select('full_name','username','status','email','created_at','updated_at','id','image');
        return DataTables::of($model)
        ->setRowId(function ($user) {
            return $user->id;
        })
        ->addColumn('full_names', function($data){
            return $data->full_name;
        })
        ->addColumn('action', function($data){
            $id = $data->id;
            $button = '<a href="users/'.$data->id.'" class="btn btn-xs btn-info" title="Show '. $this->panel.'Detail"'
            .'name="Show" id="'.$data->id.'"><i class="fa fa-eye"></i></a> ';
            $button .= '<td><a href="'.route('admin.users.edit',$data->id).'" class="btn btn-xs btn-success" title="Edit '. $this->panel.'Detail"'
            .'name="Edit" id="'.route('admin.users.show',$data->id).'"><i class="fa fa-edit"></i></a> ';
            $button .= '<a href="javascript:void" class="edit btn btn-danger btn-xs delete" data_id="'.$data->id.'"'
            .'name="Delete" id="delete"><i class="fa fa-trash"></i></a></td>';

            return $button;
        })
        ->addColumn('roles', function($data){
            $roles = Role::all();
            $user_roles='';
            foreach($roles as $role){
                 $user_roles .= in_array($role->id,usersRoleIds($data))?' '.$role->name.',' :null;
            }

            return $user_roles;
        })
        ->addColumn('image', function($data){
            if($data->image !=''){
                $image = '<a href="'.asset("storage/".$this->folder_name.'/'.$data->image).'"'
                .'data-lightbox="mygallery" title="Edit'.$data->full_name.'">'
                .'<img src="'.asset("storage/".$this->folder_name.'/'.$data->image).'"
                 .data-lightbox="mygallery" alt="" style="width:210px"/></a>';
            }else{
                $image = '<a href="'.asset('storage/defaults.png').'" data-lightbox="mygallery">'
                .'<img src="'.asset('storage/defaults.png').'" '
                 .'data-lightbox="mygallery" alt="" style="width:210px"/></a>';
            }

            return $image;
        })
        ->addColumn('status', function($data){
            $checked = '';
            if($data->status ==1){
                $checked = 'checked';
            }
            return '<input class="status" type="checkbox" name="status" data-toggle="toggle" data-on="Active" data-off="Off" data-onstyle="success" data-offstyle="danger" data-id="'.$data->id.'" '.$checked.'>';
        })

        ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
        })

        ->addIndexColumn()
        ->rawColumns(['action','image','full_names','roles','status'])
        ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      return view($this->base_route.'.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view($this->base_route.'.add')->with(['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //$data = \Location::get($request->ip());
        $user = User::create(array_merge($request->validated(),$this->commonData($request)));
        $user->roles()->sync($request->roles);

        //spatie role
        $user->assignRole($request->roles);
        session()->flash('success', 'Success The ' . $this->panel . ' Has Been Store');
        return redirect()->route($this->base_route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrfail($id);
        return view($this->base_route.'.show')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(!$data = User::find($id)){
            session()->flash('message','Sorry The '.$this->panel_name.' Has Been Deleted Or Not Present In The Database');
            return redirect()->route($this->base_route);
        }
        // if(!$data['row']->canEdit()){
        //     session()->flash('message',"Sorry The Currently Logged In '.$this->panel_name.' Cannot Edit It's Own Account");
        //     return redirect()->back();
        // }
        $roles = Role::all();
        return view($this->base_route.'.edit')->with(['data'=>$data,'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if(!$model = User::find($id)){
            session()->flash('error','Sorry The '.$this->panel.' Has Been Deleted Or Not Present In The Database');
            return redirect($this->base_route);
        }

        $model->update(array_merge($request->validated(),$this->commonData($request,$model)));
        $model->roles()->sync($request->roles);
        //spatie role
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $model->assignRole($request->input('roles'));

        session()->flash('success','Success The '.$this->panel.' Has Been Updated Now');
        return redirect()->route($this->base_route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy(Request $request,$id)
     {
        if(!$data = User::find($request->id)){
            return response()->json(['error'=>'Error ' . $this->panel . ' Not Found Or Has Been Deleted'],404);
        }

        if($data->id == auth()->user()->id){
            return response()->json(['error'=>'Error Can\'t Delete Currently Logged In User'],404);
        }

        deleteFile($data->image,$this->folder_name);

        $data->delete();
        return response()->json(['success'=>'Success The ' . $this->panel .' Name ('.$data->email.') Has Been Deleted'],200);
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
