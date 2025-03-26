<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e) {
            if(request()->wantsJson()){
                return response()->json([
                    'message'=>'Sorry '.array_reverse(explode('\\'
                    ,$e->getPrevious() != null ? $e->getPrevious()->getModel() : " Related Data"))[0].' Not Found'
                ],404);
            }
        });

        $this->renderable(function(ErrorException $e){
            if(request()->wantsJson()){
                return response()->json(['message'=>"Sorry Result not found"]);
            }
        });
        $this->renderable(function(QueryException $e){
            if(request()->wantsJson()){
                Log::critical('Sorry Invalid Query Detected',
                    ['ip_address'=>request()->ip(),'user'=>auth()->user()]);
                return response()->json(['message'=>"Sorry Invalid Query Detected"]);
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
        return response()->json(['message' => $exception->getMessage()], 401);
        }
        if( $request->is('api/*')){
        return response()->json(['message' => $exception->getMessage()], 401);
        }else{
            $guard = \Arr::get($exception->guards(), 0);
            switch ($guard) {
                case 'admin':
                    $login = 'super_admin.login';
                    break;
                default:
                if(\request()->is('admin/*')){
                    $login = 'admin.login';
                    }else{
                    $login = 'login';
                    break;
                    }

            }
            return redirect()->guest(route($login));
        }

    }
}
