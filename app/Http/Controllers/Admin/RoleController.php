<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\FormValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    public $base_route = 'admin.roles.';
    public $folder_path;
    public $folder;
    public $panel = 'Role';
    public $folder_name = 'Role';
    public $images_path;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sortBy');
        $sorting = $request->input('sorting');
        $perPage = $request->perPage != null ? $request->perPage : 10;

        $data = Role::orderBy(getOrderByParam('column'), getOrderByParam('sort'))
        ->paginate();
        if($request->ajax()){
            return view($this->base_route.'includes.tables', compact('data'))->render();
        }else{
            return view($this->base_route.'index')->with(['data'=>$data]);
        }


        $data = Role::where('status',1)->latest()->paginate($perPage);
        return view($this->base_route.'index')->with(['data'=>$data]);
    }

    public function short_query(Request $request)
  {
        $this->validate($request, [
            'status' => 'nullable|numeric'
        ]);

        $response['error'] = true;

        $this->validate($request, [
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|numeric',
            'discounts' => 'nullable|numeric',
            'status' => 'nullable|numeric'
          ]);

          if ($request->ajax()) {
            $response['error'] = true;
            if ($request->has('status')) {
              $data = Role::findOrfail($request->id);
              $data->update(['status' => $request->status]);
              $response['message'] = 'Status Has Been Updated';
              $response['error'] = false;
              return response()->json(json_encode($response));
            }
          }
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->base_route.'forms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormValidation $request)
    {
        $role = Role::create(array_merge($request->validated(),$this->commonData($request)));
        $role->syncPermissions($request->input('permission'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(!$data = Role::find($id)){
            session()->flash('message','Sorry The '.$this->panel_name.' Has Been Deleted Or Not Present In The Database');
            return redirect()->route($this->base_route);
        }
        // if(!$data['row']->canEdit()){
        //     session()->flash('message',"Sorry The Currently Logged In '.$this->panel_name.' Cannot Edit It's Own Account");
        //     return redirect()->back();
        // }
        return view($this->base_route.'.forms')->with(['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormValidation $request, $id)
    {
        if(!$model = Role::find($id)){
            session()->flash('error','Sorry The '.$this->panel.' Has Been Deleted Or Not Present In The Database');
            return redirect($this->base_route);
        }
        if($request->hasFile('image')){
            $file_name = files_uploads($request->image,$this->folder_name,$model->image);
        }
        $model->update(array_merge($request->validated(),[
                    'image'=>isset($file_name) ? $file_name : null,
                    'description'=>$request->description,
                    'slider_key'=>$request->slider_key,
                    'alt_text'=>$request->alt_text,
                    'used_for'=>$request->used_for,
                    'user_id'=>auth()->id(),
                    'used_for'=>$request->used_for,
                    'status'=>$request->has('status')
        ]));
        $model->syncPermissions($request->input('permission'));
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
        if(!$data = Role::find($request->id)){
            return response()->json(['error'=>'Error ' . $this->panel . ' Not Found Or Has Been Deleted'],404);
        }

        if($data->id == auth()->user()->id){
            return response()->json(['error'=>'Error Can\'t Delete Currently Logged In User'],404);
        }

        if ($data->image != '' &&  Storage::exists($data->image)){
            Storage::delete($data->image);
        }

        $data->delete();
        return response()->json(['success'=>'Success The ' . $this->panel .' Name ('.$data->email.') Has Been Deleted'],200);
    }

    private function commonData($request,$model=null){
        if($request->hasFile('image')){
            $file_name = files_uploads($request->image,$this->folder_name,$model != null ? $model->image:null);
        }
        $data = [
            'description'=>$request->description,
            'slider_key'=>$request->slider_key,
            'alt_text'=>$request->alt_text,
            'used_for'=>$request->used_for,
            'user_id'=>auth()->id(),
            'used_for'=>$request->used_for,
            'status'=>$request->has('status')
        ];

        if($model){
            $data = [
                'password'=>$request->filled('password') ? Hash::make($request->password): $model->password,
                'image'=>isset($file_name) ? $file_name : $model->image
            ];

        }

        return $data;
    }
}
