<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if(request()->is('admin/login') && auth('admin')->check()){
            session()->flash('success','You Are logged in As Super Admin Now');
            return redirect()->route('super_admin.index');
        }

        if(!auth()->check()){
            if(request()->is('admin/login')){
                return view('auth.login');
            }else{
                return view('auth.admin_login');
            }
        }else{
            if(check_role('admin')){
                session()->flash('success','You Are logged in As Admin Now');
                return redirect()->route('admin.index');
            }else{
                session()->flash('success','You Are logged in As User Now');
                return redirect()->route('index');
            }
        }

        abort(404);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            session()->regenerate();
            $this->clearLoginAttempts($request);
            foreach (auth()->user()->roles as $key => $role) {
                if($role->key == 'admin'){
                    if(url()->previous() == route('admin.login')){
                        session()->flash('success','your are logged in as administrator rights ');
                        return redirect()->intended('admin/index');
                    }else{
                        session()->flash('success','Please Login From Admin URL');
                        return redirect()->route('auth_reset');
                    }

                }elseif($role->key == 'user'){
                    if(url()->previous() == route('login')){
                        session()->flash('success','your are logged in as administrator rights ');
                        return redirect()->intended('frontend/index');
                    }else{
                        session()->flash('success','Please Login From Authorize URL');
                        return redirect()->route('auth_reset');
                    }
                    session()->flash('success','from login route and user');
                    return redirect()->intended('home');
                }
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

     public function redirectToProvider( $provider ) {

        return Socialite::driver( $provider )->redirect();
    }

    public function handleProviderCallback( $provider ) {
        try {
            if ( $provider != 'facebook' ) {
                $user = Socialite::driver( $provider )->user();
            } else {
                $user = Socialite::driver( $provider )->fields(
                    [
                        'id',
                        'name',
                        'first_name',
                        'last_name',
                        'email',
                    ]
                )->user();
            }

        } catch ( \Exception $e ) {
            return redirect()->to( '/login' );
        }

        $authUser = $this->findOrCreateUser( $user, $provider );

            auth()->login( $authUser, true );

        return redirect()->to( '/' );
    }

    private function findOrCreateUser( $socialLiteUser, $key ) {
        $email = $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'];


        if ( $authUser = User::where( 'email', $email )->first() ) {
            return $authUser;
        }

        $user = User::create( [
            'first_name'  => $key != 'facebook' ? $socialLiteUser->user['name'] : $socialLiteUser->user['first_name'],
            'last_name'   => $key != 'facebook' ? $socialLiteUser->user['name'] : $socialLiteUser->user['last_name'],
            'email'       => $key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email'],
            'password'    => bcrypt( \Str::random( 10 ) ),
            'provider'    => $key,
            'remember_token' => base64_encode($key != 'facebook' ? $socialLiteUser->email : $socialLiteUser->user['email']),
            'verified'    => 1,
            'provider_id' => $key != 'facebook' ? $socialLiteUser->id : $socialLiteUser->user['id'],
            'user_name'   => $key != 'facebook' ? $socialLiteUser->name : $socialLiteUser->user['name'],
        ] );
        $user->roles->sync([3]);
        return $user;



    }
}
