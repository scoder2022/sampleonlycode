<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SiteHelper;

class ProductController extends Controller
{
    public $base_route = 'admin.products';
    public $folder_path;
    public $folder;
    public $panel = 'Products';
    public $model = 'App\Models\Product';
    public $folder_name = 'Products';
    public $images_path;

    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function getProducts(Request $request)
    {
        $model = User::select('full_names', 'username', 'status', 'email', 'updated_at', 'id', 'image');
        return DataTables::of($model)
            ->setRowId(function ($user) {
                return $user->id;
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $button = '<a href="Products/' . $data->id . '" class="btn btn-xs btn-info" title="Show ' . $this->panel . 'Detail"'
                    . 'name="Show" id="' . $data->id . '"><i class="fa fa-eye"></i></a> ';
                $button .= '<td><a href="' . route('admin.Products.edit', $data->id) . '" class="btn btn-xs btn-success" title="Edit ' . $this->panel . 'Detail"'
                    . 'name="Edit" id="' . route('admin.Products.show', $data->id) . '"><i class="fa fa-edit"></i></a> ';
                $button .= '<a href="javascript:void" class="edit btn btn-danger btn-xs delete" data_id="' . $data->id . '"'
                    . 'name="Delete" id="delete"><i class="fa fa-trash"></i></a></td>';

                return $button;
            })
            ->addColumn('image', function ($data) {
                if ($data->image != '') {
                    $image = '<a href="' . asset("storage/" . $this->folder_name . '/' . $data->image) . '"'
                        . 'data-lightbox="mygallery" title="Edit' . $data->first_name . '">'
                        . '<img src="' . asset("storage/" . $this->folder_name . '/' . $data->image) . '"
                 .data-lightbox="mygallery" alt="" style="width:210px"/></a>';
                } else {
                    $image = '<a href="' . asset('storage/defaults.png') . '" data-lightbox="mygallery">'
                        . '<img src="' . asset('storage/defaults.png') . '" '
                        . 'data-lightbox="mygallery" alt="" style="width:210px"/></a>';
                }

                return $image;
            })
            ->addColumn('status', function ($data) {
                $checked = '';
                if ($data->status == 1) {
                    $checked = 'checked';
                }
                return '<input class="status" type="checkbox" name="status" data-forc="User" data-size="mini" data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="success" data-offstyle="danger" data-id="' . $data->id . '" ' . $checked . '>';
            })

            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
            })

            ->addIndexColumn()
            ->rawColumns(['action', 'image', 'full_names', 'roles', 'status'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view($this->base_route . '.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_categories = Category::all();
        return view($this->base_route . '.add')->with(['all_categories' => $all_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request, ProductService $productservice): RedirectResponse
    {
        // foreach (config('app.available_locale') as $locale) {
        //     $rules['title_' . $locale] = 'required|string';
        // }
        $productservice->store($request);
        session()->flash('success', 'Success The ' . $this->panel . ' Has Been Store');
        return redirect()->route($this->base_route . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->model::findOrfail($id);
        return view($this->base_route . '.show')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$data = $this->check_exists($id, $this->model)) {
            return redirect()->route($this->base_route . '.index');
        }
        $all_categories = Category::all();
        return view($this->base_route . '.edit')->with(['data' => $data, 'all_categories' => $all_categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Productservice $Productservice, $id)
    {
        if (!$user = $this->model::find($id)) {
            session()->flash('error', 'Sorry The ' . $this->panel . ' Has Been Deleted Or Not Present In The Database');
            return redirect($this->base_route);
        }
        $Productservice->update($request, $user);
        session()->flash('success', 'Success The ' . $this->panel . ' Has Been Updated Now');
        return redirect()->route($this->base_route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $data = check_exists($id, $this->model);
        check_gates('canDelete', 'Error Can\'t Delete Currently Logged In User', $data);
        deleteFile($data->image, $this->folder_name);

        $data->delete();
        return success('Success The ' . $this->panel . ' Name (' . $data->email . ') Has Been Deleted', 200);
    }
}
