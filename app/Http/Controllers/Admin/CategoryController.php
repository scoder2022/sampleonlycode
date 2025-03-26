<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\AllValidations;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SiteHelper;

class CategoryController extends Controller
{
    public $base_route = 'admin.category';
    public $folder_path;
    public $folder;
    public $panel = 'Category';
    public $folder_name = 'Category';
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
        $perPage = $request->perPage != null ? $request->perPage : 10;
        $data = Category::when($search !='', function ($query) use ($search){
            $query->whereLike('first_name', $search);
        })
        ->orderBy(getOrderByParam('column'), getOrderByParam('sort'))
        ->paginate();
        $all_categories = Category::where('parent_id',0)->get();
        if($request->ajax())
            return view($this->base_route.'.tables', compact('data'))->render();

            return view($this->base_route.'.index')->with(['data'=>$data,'all_categories'=>$all_categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_categories = Category::where('parent_id',0)->get();
        return view($this->base_route.'.forms')->with(['all_categories'=>$all_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('here');
        if($request->hasFile('image')){
            $file_name = files_uploads($request->image,$this->folder_name);
        }

        $Category = Category::create(array_merge($request->all(),[
            'slug'=>str_slug($request->name),
            'image'=>isset($file_name)?$file_name:null,
            'status'=>$request->has('status')
        ]));

        $request->session()->flash('success', 'Success The ' . $this->panel . ' Has Been Store');
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
        if(!$data = Category::find($id)){
            $request->session()->flash('message','Sorry The '.$this->panel_name.' Has Been Deleted Or Not Present In The Database');
            return redirect()->route($this->base_route);
        }
        $all_categories = Category::where('parent_id',0)->get();
        // if(!$data['row']->canEdit()){
        //     $request->session()->flash('message',"Sorry The Currently Logged In '.$this->panel_name.' Cannot Edit It's Own Account");
        //     return redirect()->back();
        // }
        return view($this->base_route.'.edit')->with(['data'=>$data,'all_categories'=>$all_categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AllValidations $request, $id)
    {
        if(!$model = Category::find($id)){
            $request->session()->flash('error','Sorry The '.$this->panel.' Has Been Deleted Or Not Present In The Database');
            return redirect($this->base_route);
        }
        if($request->hasFile('image')){
            $file_names = $this->files_uploads($request->image,$model->image);
        }
        $model->update($request->except('status'));

        $request->session()->flash('success','Success The '.$this->panel.' Has Been Updated Now');
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
        if(!$model = Category::find($request->id)){
            return response()->json(['error'=>'Error ' . $this->panel . ' Not Found Or Has Been Deleted'],404);
        }

        if ($model->image != '' && file_exists($model->image)){
            Storage::delete($model->image);
        }

        $model->delete();
        return response()->json(['success'=>'Success The ' . $this->panel .' Name ('.$model->name.') Has Been Deleted'],200);
    }
}
