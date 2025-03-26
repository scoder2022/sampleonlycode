<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ExtraRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ExtraTraits;

class AdminController extends Controller
{
    use ExtraTraits;
    public $base_route = 'admin.users';
    public $folder_path;
    public $folder;
    public $panel = 'Dashboard';
    public $folder_name = 'Dashboard';
    public $images_path;


    public function index()
    {

        return view('admin.index');
    }

    public function status_changes(Request $request)
    {

        // str_replace(url('/'), '', url()->previous())
        // $url = url()->previous();
        // $urlarray=explode("/",$url);
        // $table=$urlarray[count($urlarray)-1];
        $response['error'] = true;
        $forc = Str::lower(Str::plural($request->forc));
        $this->validate($request, [
            'status'=>'required|boolean',
            'status_for'=>new ExtraRules(),
            'id'=>'required|exists:'.$forc.',id',
         ],[
             'id'=>'Invalid Request',
         ]);

        if (!DB::table($forc)->where('id',$request->id)
            ->update(['status'=>$request->status])){
            $response['message'] = 'Invalid Request';
            return response()->json(json_encode($response));
        }

        $response['message'] = 'Status Has Been Updated';
        $response['error'] = false;
        return response()->json(json_encode($response));
    }

    public function clearSite(Request $request){
        Artisan::call('config:clear');
        dump('Config Clear');
        Artisan::call('config:cache');
        dump('Config Cache');
        Artisan::call('route:cache');
        dump('Route Cache');
        Artisan::call('cache:clear');
        dump('Cache Clear');
        Artisan::call('view:cache');
        dump('View Cache');
        Artisan::call('optimize:clear');
        dump('optimize Clear');
        return redirect()->route('admin.users.index');
    }

    public function clearCache(Request $request){
        Artisan::call('config:cache');
        dump('Config Cache');
        Artisan::call('route:cache');
        dump('Route Cache');
        Artisan::call('view:cache');
        dd('View Cache');
    }



    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('storage/CkEditor/'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/CkEditor/'.$fileName);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
