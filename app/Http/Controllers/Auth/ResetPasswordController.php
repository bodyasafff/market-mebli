<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\PasswordResetStoreRequest;
use App\Models\PasswordReset;
use Illuminate\Http\Request;

class ResetPasswordController extends DashboardController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function passwordReset(Request $request)
    {
        if (!isset($request->token) || !PasswordReset::whereToken($request->token)->first()) {
            return view('auth.message', [
                'status'  => false,
                'message' => 'Link has expired!',
            ]);
        }

        return view('auth.password-reset', [
            'token' => $request->token,
        ]);
    }

    public function passwordResetStore(PasswordResetStoreRequest $request)
    {
        if ($passwordReset = PasswordReset::whereToken($request->token)->first()) {
            $passwordReset->user()->update([
                'password' => bcrypt($request->password)
            ]);

            $passwordReset->delete();

            return view('auth.message', [
                'status'  => true,
                'message' => 'Password changed successfully!',
            ]);
        }

        return redirect()->back();
    }
}
