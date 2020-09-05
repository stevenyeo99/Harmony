<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\HsUser;
use App\Enums\StatusType;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Override custom logout
     */
    public function logout(Request $request) {
        $this->performLogout($request);

        $request->session()->invalidate();

        return redirect()->route('login');
    }

    /**
     * use user_name instead of email
     */
    public function username() {
        return 'user_name';
    }

    /**
     * send failed login validation message
     */
    public function sendFailedLoginResponse(Request $request) {
        if (HsUser::where('user_name', $request->user_name)->where('status', StatusType::INACTIVE)->first()) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => trans('auth.inactive'),
                ]);
        }
        
        if (!HsUser::where('user_name', $request->user_name)->first()) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => trans('auth.user_name'),
                ]);
        }

        if (!HsUser::where('user_name', $request->user_name)->where('password', bcrypt($request->password))->first()) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'password' => trans('auth.password'),
                ]);
        }
    }
}
