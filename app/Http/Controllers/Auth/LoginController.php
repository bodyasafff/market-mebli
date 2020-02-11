<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends DashboardController
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
    protected $redirectTo = '/dashboard/redirect/after-login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $action = $request->route()->getAction();
        if( !empty($action['controller']) && $action['controller'] == 'App\Http\Controllers\Auth\LoginController@showLoginForm'){
            $this->middleware(function ($request, $next) {
                if(\Auth::user()){
                    $this->guard()->logout();
                    $request->session()->invalidate();
                    return redirect()->route('login');
                }
                return $next($request);
            });
        }

        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
