<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/home'; //用户登录成功,要跳转的url地址

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //直接给中间件传递guard参数
        $this->middleware('guest:admin', ['except' => 'logout']);
       // $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name'; //用户名对应的字段
    }

    /*protected function guard()
    {
        return Auth::guard('admin');
    }*/
}
