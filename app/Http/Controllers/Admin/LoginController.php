<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/admin/dashboard';
    private $rememberToken = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        // Attempt to authenticate user
        // If successful, redirect to their intended location
        $guard = config('constants.guard.admin');
        if (Auth::guard($guard)->attempt(['email' => $request->email, 'password' => $request->password], $this->rememberToken)) {
            $user = Auth::guard($guard)->user();
            if ($user->checkIsAdmin()) {

                if (strpos($request->session()->get('url.intended'), '/' . $guard) !== false) {

                    return redirect($request->session()->get('url.intended'));
                }

                return redirect(route('admin.dashboard'));
            } else {
                Auth::guard($guard)->logout();
                // User cannot access admin page
                return redirect()->back()->with('error', __('users.access_error'))->withInput($request->only('email', 'remember'));
            }
        }
        $this->sendFailedLoginResponse($request);
        // Authentication failed, redirect back to the login form
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        $guard = config('constants.guard.admin');
        Auth::guard($guard)->logout();
        $request->session()->put('url.intended', null);
        // Flush anything session admin site
        return redirect(route('admin.login'));
    }
}
