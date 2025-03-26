<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guard = get_guard();
            if ($guard == 'admin' && Auth::guard($guard)->check()) {
                if(request()->is('super_admin/*')){
                    return redirect(RouteServiceProvider::SuperAdmin);
                }
                if(Auth::guard('web')->check()){
                    if(check_role('admin') && !request()->is('login')){
                        return redirect(RouteServiceProvider::Admin);
                        }else if(check_role('user')){
                            return redirect(RouteServiceProvider::HOME);
                        }
                }
                    return $next($request);
            }elseif($guard == 'web' && Auth::guard($guard)->check()){
                if(check_role('admin') && request()->is('admin/login')){
                    session()->flash('error','You Are logged As Admin');
                    return redirect(RouteServiceProvider::Admin);
                }else if(check_role('user')  && request()->is('login')){
                    if(request()->is('super_admin/*')){
                        return $next($request);
                    }
                    return redirect(RouteServiceProvider::HOME);
                }
            }elseif(auth()->check()){
                session()->flash('error','you have to logout first to login to another account');
                return redirect()->route('auth_reset');
            }

            return $next($request);
    }
}
