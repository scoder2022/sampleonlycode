<?php

use App\Models\Category;
use App\Models\Configuration;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

if (!function_exists('check_gates')) {
    function check_gates($name,$response_message,$data){
        if (! Gate::allows($name, $data)) {
            return response()->json(['error'=>$response_message],403);
        }
        return true;
    }
}

if (!function_exists('success')) {
    function success(string $message,int $code=200,$data=null){
        $response=[
            'success'=>true,
            'message'=>$message,
        ];
        if(null!=$data){
            $response['data']=$data;
    }
    return response()->json($response,$code);
    }
}

if (!function_exists('error')) {
    function error(string $message,int $code=200,$data=null){
        $response=[
            'success'=>false,
            'message'=>$message,
        ];
        if(null!=$data){
            $response['data']=$data;
    }
    return response()->json($response,$code);
    }
}

if(!function_exists('files_uploads')){

    function files_uploads($file, $folder_name, $oldfile = null)
    {
        if (!Storage::has('Uploads'.DIRECTORY_SEPARATOR.$folder_name)) {
            Storage::makeDirectory('Uploads'.DIRECTORY_SEPARATOR.$folder_name);
        }

        if ($oldfile != null && Storage::exists('Uploads'.DIRECTORY_SEPARATOR.$folder_name . DIRECTORY_SEPARATOR . $oldfile)) {
            Storage::delete('Uploads'.DIRECTORY_SEPARATOR.$folder_name . DIRECTORY_SEPARATOR . $oldfile);
        }

        $file_name =  $folder_name . '_' . rand(0, 999999).'.'.$file->extension();
        $file->storeAs('Uploads'.DIRECTORY_SEPARATOR.$folder_name, $file_name,'public');
        return $file_name;
    }
}

if(!function_exists('show_image')){

    function show_image($folder_name,$file_name=null){
        if($file_name != null && file_exists('storage/Uploads/'.$folder_name.'/'.$file_name)){
            $thumbnail = asset('storage/Uploads/'.$folder_name.'/'.$file_name);
        }else{
            $thumbnail = asset('storage/Uploads/defaults.png');
        }
        return $thumbnail;
    }
}

if(!function_exists('deleteFile')){
    function deleteFile($image,$folder_name){
        if ($image != null && Storage::exists('Uploads'.DIRECTORY_SEPARATOR.$folder_name . DIRECTORY_SEPARATOR . $image)) {
            Storage::delete('Uploads'.DIRECTORY_SEPARATOR.$folder_name . DIRECTORY_SEPARATOR . $image);
        }
    }
}



if(!function_exists('localImageFile')){
    function localImageFile( $relativePath = null ) {

        $image_path = [];
        $sizes = config( 'image.sizes' );

        foreach ( $sizes as $sizeName => $value ) {
            $baseName     = basename( $relativePath );
            $sizeNamePath = str_replace( $baseName, $sizeName . "-" . $baseName, $relativePath );
            $image_path[$sizeName] = $sizeName . "-" . $baseName;
        }

        return $image_path;
    }
}



if (!function_exists('product_price')) {

    function product_price($product,$data,$currency=false){
        $p_data = [];
        $p_data['sale_price'] = $product->sale_price;
        $p_data['price'] = $product->price;
        if ($p_data['price'] != null || $p_data['price'] != 0) {
            $p_data['discount_prices'] = $p_data['price'] - $p_data['sale_price'];
            $p_data['discount_percentage'] = round(($p_data['discount_prices']  * 100) / $p_data['sale_price']);
        }
        if($data !='discount_percentage' && $currency){
            return currency_type().' '.$p_data[$data];

        }else{
            return $p_data[$data];
        }
    }
    }

    if(!function_exists('currency_type')){
        function currency_type(){
            $ct = Configuration::where('key', 'currency_type')->first();
            return $ct->text??"Rs";
        }
    }


function getProductImage($id, $size = null)
{
  $product = DB::table('products')
    ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
    ->where('product_images.is_main_image', '=', 1)
    ->where('products.id', '=', $id)
    ->select('product_images.path')
    ->first();

  if (null === $product || empty($product)) {
    $defaultPath = "/img/default-product.jpg";
    $localImage = localImageFile($defaultPath);
  } else {
    $localImage =  localImageFile($product->path);
  }
  switch ($size) {
    case "small":
      $imageUrl = $localImage['small'];
      break;
    case "medium":
      $imageUrl = $localImage['medium'];
      break;
    case "large":
      $imageUrl = $localImage['large'];
      break;
    case "largeSlideshow":
      $imageUrl = $localImage['largeSlideshow'];
      break;
    default:
      $imageUrl = "/img/default-product.jpg";
  }
  return $imageUrl;
}

function setChecker($data,$value){
    return isset($data) ? $data->$value : old($value);
}

function checked_values($action,$target,$now){
        if($now == $target){
         if($action == 'select'){
             return 'selected="selected"';
         }elseif($action == 'check'){
             return 'checked="checked"';
         }
        }
        return false;
 }

 function usersRoleIds(User $user){
     $roles = $user->roles;
     $arr = [];
     foreach ($roles as $role){
         $arr[] = $role->id;
     }
     return $arr;
 }


 function getOrderByParam($param)
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

 function check_role($current_role)
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

 function check_guard($guard){
     if($guard == 'admin'){
        return Auth::guard($guard)->check() ? true : false;
     }elseif ($guard == 'web') {
        return Auth::guard($guard)->check() ? true : false;
     }else{
         return false;
     }
 }

 function check_guard_login(){
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
 function get_guard(){
     if(Auth::guard('admin')->check()){
         return "admin";
     }elseif(Auth::guard('web')->check()){
         return "web";
     }else{
         return false;
     }
 }
function testff()
{
    dd('in');
}

function getCategories() {

    $categories = Category::where( 'parent_id', 0 )->get();

    $categories = addRelation( $categories );

    return $categories;

}

function getProductsByCategory($category)
{
    switch ($category) {
        case 'Latest':
            $products = Product::where('status', '=', 'published')
                ->where('approved', 1)->orderby('id', 'DESC')->take(10)->get();
            break;
        case 'Featured':
            $products = Product::where('is_featured', 1)->where('status', '=', 'published')
                ->where('approved', 1)->orderby('id', 'DESC')->take(10)->get();
            break;
        default:
            $categories = Category::where('name', $category)->get();
            $categories = addRelation($categories);
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->id;
                if ($category->subCategory->isNotEmpty()) {
                    foreach ($category->subCategory as $sub) {
                        $category_ids[] = $sub->id;
                        if ($sub->subCategory->isNotEmpty()) {
                            foreach ($sub->subCategory as $child) {
                                $category_ids[] = $child->id;
                                if ($child->subCategory->isNotEmpty()) {
                                    foreach ($child->subCategory as $cat) {
                                        $category_ids[] = $cat->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $product_ids = DB::table('category_product')->whereIn('category_id', $category_ids)->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $product_ids)->where('status', '=', 'published')->orderby('id', 'DESC')->take(15)->get();
    }

    return $products;
}

function selectChild( $id ) {
    $categories = Category::where( 'parent_id', $id )->get(); //rooney

    $categories = addRelation( $categories );

    return $categories;

}

function addRelation( $categories ) {

    $categories->map( function ( $item, $key ) {

        $sub = selectChild( $item->id );

        return $item = array_add( $item, 'subCategory', $sub );

    } );

    return $categories;
}
