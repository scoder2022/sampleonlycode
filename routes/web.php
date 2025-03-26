<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\OrderShipped;
use App\Mail\PurchaseInvoiceInformation;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use Livewire\Admin\Category\Lists;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\App;

Route::get('set_language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/auth', function () {
    \Auth::attempt(['email' => 'admin@admin.com', 'password' => 'admin@admin.com']);
});

Route::get('surf', function () {
    $data = User::where('id', 100000)->exists();
    dd($data);
});

Route::get('/test', function () {
    $user = User::find(1);
    $user->givePermissionTo('super_editor');

    dd($user);
    $ff = DB::table('users')->where('id', 1000000)->update(['status' => 0]);
    $price = 'Range: $1 - $205';
    dd(explode('Range: ', explode('-', $price)));
    dd(loadProducts('categories', [1, 2]));
    $categories = [1, 2, 4];
    $products = Product::when($categories, function ($query, $categories) {
        return $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories);
        });
    })->get();
    dd($products);
});
Route::get('/', 'Frontend\HomeController@index')->name('index');
Route::get('secret', function () {
    $data = [
        "to" => "uniquecoder11@gmail.com",
        "attachments" => [
            [
                "path" => public_path('storage/file.pdf'),
                "as" => "File.pdf",
                "mime" => "application/pdf",
            ],
            [
                "path" => public_path('storage/cv.pdf'),
                "as" => "CV.pdf",
                "mime" => "application/pdf",
            ],
            [
                "path" => public_path('storage/test.pdf'),
                "as" => "Test.pdf",
                "mime" => "application/pdf",
            ],
        ],
    ];
    dd(Mail::to($data['to'])->send(new PurchaseInvoiceInformation($data)));
    // $user = User::latest()->first();
    // Mail::to('file@check.ocm')->send(new OrderShipped($user));
    // dd('ok');
    $sd = date('Y-m-d H:i:s');
    dd(date('Y-m-d H:i:s', strtotime("$sd +10 days")));

    $products = $product = Product::findOrfail(1)->attributes;

    foreach ($products as $product) {
        dump($product);
    }
    dd('out');
    // $user = User::latest()->first();
    // Mail::to('file@check.ocm')->send(new OrderShipped($user));

    // Alert::alert('Title', 'Message', 'Type');
});

use Intervention\Image\Facades\Image;

Route::get('images', function () {
    // Create new image with transImage background color
    $sizes = config('image.sizes');
    foreach ($sizes as $sizeName => $widthHeight) {
        $img = Image::make('storage/Uploads/sl.png');
        list($width, $height) = $widthHeight;
        $canvas = Image::canvas($width, $height, array(255, 255, 255, 0));
        // Read image file and resize it to 200x200
        // But keep aspect-ratio and do not size up,
        // So smaller sizes don't stretch
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $file_name = rand(0, 111);
        // Insert resized image centered into background
        $canvas->insert($img, 'center');
        $canvas->save('storage/Uploads/' . $file_name . '.png');
    }
    dd('ok');
    return $img->response('jpg');
});

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();

//forgot passwords controller
Route::post('/super_admin/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('super_admin.password.email');
Route::post('/super_admin/password/reset', 'Auth\AdminResetPasswordController@reset')->name('super_admin.password.update');
Route::get('/super_admin/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('super_admin.password.request');
Route::get('/super_admin/password/reset/{token?}/{email?}', 'Auth\AdminResetPasswordController@showResetForm')->name('super_admin.password.reset');

Route::get('/super_admin/login', 'Auth\AdminLoginController@showLoginForm')->name('super_admin.login');
Route::post('/super_admin/login', 'Auth\AdminLoginController@login')->name('super_admin.login.process');

Route::get('/auth_reset', 'ExtraController@auth_reset')->name('auth_reset');
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\LoginController@login')->name('admin.login.process');


Route::group(['prefix' => 'admin/', 'namespace' => 'Admin\\', 'as' => 'admin.', 'middleware' => ['AdminRoleValidation']], function () {
    //status change
    Route::post('status_changes', 'AdminController@status_changes')->name('status_changes');
    //section of Manufacturers
    Route::post('manufacturer/short_query', 'ManufacturerController@short_query')->name('manufacturer.short_query');
    Route::resource('manufacturer', 'ManufacturerController');

    //section of Permission
    Route::post('permissions/short_query', 'PermissionController@short_query')->name('permissions.short_query');
    Route::resource('permissions', 'PermissionController');

    //section of Banner
    Route::post('banners/short_query', 'BannerController@short_query')->name('banners.short_query');
    Route::resource('banners', 'BannerController');

    Route::resource('category', 'CategoryController');
    Route::post('category/short_query', 'ProductController@short_query')->name('category.short_query');
    // site cache remove urls
    Route::get('clear-site', 'AdminController@clearSite')->name('clear-site');
    Route::get('clear-cache', 'AdminController@clearCache')->name('clear-cache');
    //section of pages
    Route::post('pages/short_query', 'PageController@short_query')->name('pages.short_query');
    Route::resource('pages', 'PageController');
    Route::post('ckeditor/upload', 'AdminController@upload')->name('ckeditor.image-upload');
    //section of products
    Route::post('products/short_query', 'ProductController@short_query')->name('products.short_query');
    Route::resource('products', 'ProductController');
    //end section
    Route::post('users/short_query', 'UserController@short_query')->name('users.short_query');
    Route::resource('users', 'UserController');
    Route::get('site_settings', 'SiteSettingsController@index')->name('site_settings.index');
    //Route::get('search/{search}', 'UsersController@index');
    Route::get('getUsers', 'UserController@getUsers')->name('users.getUsers');
    Route::get('index', 'AdminController@index')->name('index');
    // Route::view('menus', 'admin.menus.index')->name('menus');
    Route::get('menus', 'MenuController@index')->name('menu.index');
    Route::get('/menu/view', 'MenuController@show')->name('menu.show');
    Route::post('/menu/addmenu', 'MenuController@addmenu')->name('haddmenu');
    Route::get('/settings', 'SiteSettingsController@getConfiguration')->name('settings');
    Route::post('/settings', 'SiteSettingsController@postConfiguration')->name('settings.update');
});

Route::group(['prefix' => 'super_admin/', 'as' => 'super_admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('index', 'SuperAdminController@index')->name('index');
});


Route::group(['prefix' => 'customer', 'middleware' => ['customerRole']], function () {
    Route::get('dashboard', [
        'as' => 'customer.dashboard',
        'uses' => 'Shop\Customer\DashBoardController@index'
    ]);
});


Route::group(['namespace' => 'Frontend\\', 'as' => 'frontend.', 'middleware' => 'auth'], function () {
    Route::get('category/{slug?}', ['uses' => 'CategoryController@show'])->name('category.show');
    Route::get('home', 'DashboardController@index')->name('home');
});
Route::view('index', 'frontend.index');


// Route::get('{pages}','PagesController')->name('pages')
// ->where('pages','about-us|contact_us');
