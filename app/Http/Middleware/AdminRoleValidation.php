<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminRoleValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(\Auth::guard('admin')->check()){
            return $next($request);
        }else{
            if(\SiteHelper::check_role('admin')){
                return $next($request);
            }
            abort(403);
        }
    }
}
