<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Flasher\Noty\Prime\NotyFactory;
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

    public function login(Request $request, NotyFactory $flasher)
    {
        if (Auth::guard()->attempt(['phone_number' => $request->phone_number, 'password' => $request->password, 'login_allow' => '1'])) {
            $flasher->addSuccess('مرحبًا بعودتك');

            return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect('login')->withErrors(['error' => 'غير مسموح لك بالدخول']);
        }
    }
}
