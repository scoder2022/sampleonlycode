<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\ProductImage;

class ProductService
{
    public $base_route = 'admin.products';
    public $panel = 'Product';
    public $folder_name = 'Product';
    public $images_path;

    public function store(Request $request)
    {
        $model = Product::create(array_merge($request->validated(), $this->commonData($request)));
        dd($model);
        $this->multipleImageUpload($model, $request);
        //spatie role
        $model->assignRole($request->roles);
        $model->roles()->sync($request->roles);
        return $model;
    }

    public function update(Request $request, Product $model): Product
    {
        $model->update(array_merge($request->validated(), $this->commonData($request, $model)));
        $model->roles()->sync($request->roles);
        //spatie role
        DB::table('model_has_roles')->where('model_id', $model->id)->delete();
        $model->assignRole($request->input('roles'));
        return $model;
    }

    private function commonData($request, $model = null)
    {
        if ($request->hasFile('image')) {
            $file_name = files_uploads($request->image, $this->folder_name, $model != null ? $model->image : null);
        }

        $data = [
            "slug" => str_slug($request->name),
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,
            "seo_title" => $request->seo_title,
            "seo_keyword" => $request->seo_keyword,
            "seo_description" => $request->seo_description,
            'status' => $request->has('status')
        ];
        if ($request->has('sku') && is_array($request->get('sku'))) {
            foreach ($request->get('sku') as $key => $value) {
                DB::table('product_attributes')->insert([
                    'product_id' => $model->id,
                    'user_id' => 1,
                    'sku' => $value,
                    'size' => $request->get('size')[$key],
                    'color' => $request->get('color')[$key],
                    "prices" => $request->prices[$key],
                ]);
            }
        }
        return $data;
    }

    public function multipleImageUpload($model, $request)
    {
        $is_main = array_search(1, $request->is_main);
        if ($model) {
            if ($request->hasfile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $file_name = $this->panel . rand(0, 999999) . '.' . $file->getClientOriginalExtension();
                    $sizes = config('image.sizes');

                    foreach ($sizes as $sizeName => $widthHeight) {
                        $img = Image::make($file);
                        list($width, $height) = $widthHeight;
                        $canvas = Image::canvas($width, $height, array(255, 255, 255, 0));
                        // Read image file and resize it to 200x200
                        // But keep aspect-ratio and do not size up,
                        // So smaller sizes don't stretch
                        $img->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        // Insert resized image centered into background
                        $canvas->insert($img, 'center');
                        $folder_directory = 'Uploads/' . $this->folder_name
                            . '/' . date('Y') . '/' . date('m') . '/' . date('d')
                            . '/' . "id_4";
                        if (!Storage::has($folder_directory)) {
                            Storage::makeDirectory($folder_directory);
                        }
                        $image_name = $canvas->save('storage/' . $folder_directory . '/' . $sizeName . '-' . $file_name);
                    }
                    ProductImage::create([
                        'user_id' => 1,
                        'product_id' => $model->id,
                        'path' => 'storage/' . $folder_directory . '/' . $file_name,
                        'is_main_image' => $key == $is_main ?? 1,
                    ]);
                }
            }
        }
    }
}
