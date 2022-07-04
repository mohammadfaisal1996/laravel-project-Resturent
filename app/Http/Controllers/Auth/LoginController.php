<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $loginField = "email";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $loginField = $this->initizationLoginField();
    }

    protected function initizationLoginField(){
        $loginFieldValue = request()->input("login");
        if($loginFieldValue){
            $this->loginField = filter_var($loginFieldValue, FILTER_VALIDATE_EMAIL) ? "email" : "username";
            request()->merge([$this->loginField => $loginFieldValue]);
        }
    }

    public function username()
    {
        return $this->loginField;
    }
}
