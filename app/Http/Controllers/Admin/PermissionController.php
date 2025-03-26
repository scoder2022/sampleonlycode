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
use DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public $base_route = 'admin.permissions';
    public $folder_path;
    public $folder;
    public $panel = 'Permissions';
    public $folder_name = 'Permissions';
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
        return view($this->base_route.'.index');
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
              $data = Permission::findOrfail($request->id);
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);
       
        Permission::create(['name'=>$request->name,'guard_name'=>$request->guard_name]);
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
        if(!$data = Permission::find($id)){
            session()->flash('message','Sorry The '.$this->panel_name.' Has Been Deleted Or Not Present In The Database');
            return redirect()->route($this->base_route);
        }

        return view($this->base_route.'.forms')->with(['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$model = Permission::find($id)){
            session()->flash('error','Sorry The '.$this->panel.' Has Been Deleted Or Not Present In The Database');
            return redirect($this->base_route);
        }

        $model->update(['name'=>$request->name,'guard_name'=>$request->guard_name]);
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
        if(!$data = Permission::find($request->id)){
            return response()->json(['error'=>'Error ' . $this->panel . ' Not Found Or Has Been Deleted'],404);
        }

        if($data->id == auth()->user()->id){
            return response()->json(['error'=>'Error Can\'t Delete Currently Logged In User'],404);
        }

        $data->delete();
        return response()->json(['success'=>'Success The ' . $this->panel .' Name ('.$data->email.') Has Been Deleted'],200);
    }

}
