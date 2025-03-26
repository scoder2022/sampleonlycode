<?php

namespace App\Http\Controllers;

use App\Traits\ExtraTraits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

class Controller extends BaseController
{
    protected $model;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,ExtraTraits;
    public function __construct(){
        View::composer('*',function ($view){
            $base_route = isset($this->base_route) ? $this->base_route : '';
            $folder_name = isset($this->folder_name) ? $this->folder_name : '';
            $panel =  isset($this->panel) ? $this->panel : '';
            $view->with('base_route',$base_route);
            $view->with('folder_path', base_path(). DIRECTORY_SEPARATOR . 'public'
            . DIRECTORY_SEPARATOR .'Uploads'.DIRECTORY_SEPARATOR.$folder_name??$folder_name.DIRECTORY_SEPARATOR);
            $view->with('panel',$panel);
            //$view->with('trans_path',$this->makeTransPath($this->base_route));
            $view->with('current_images_path',asset('storage/Uploads/'.$folder_name.'/'));
            $view->with('images_path',asset('storage/Uploads/'));
            $view->with('folder_name',$folder_name);
            $view->with('current_route',$route = \Route::currentRouteName());
            $view->with('productCategories',request()->is('admin/menus*') ?  getCategories()->take(12) : '');
        });
    }
}
