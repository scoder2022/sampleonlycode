<?php
namespace App\Traits;

use App\Rules\ExtraRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ExtraTraits {


    public function check_exists($id,$model){
        if(!$data = $model::find($id)){
            session()->flash('error','Sorry! '.Str::singular($this->panel).'  Not Found');
            return false;
        }

        return $data;
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
}
