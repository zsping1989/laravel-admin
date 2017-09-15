<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use LaravelAdmin\Facades\Option;
use Resource\Facades\Data;

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
     * 验证登录字段
     *
     * @var string
     */
    protected $username = 'email|mobile_phone|uname';
    protected $authField = '';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';
    protected $redirectAfterLogout = '/open/login';
    protected $redirectToHome = '/home/index';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $data['app_name'] = config('app.name');
        Data::set('global',$data);
        return Response::returns([
            'geetest' => $this->geetest()
        ]);
    }

    /**
     * 极验验证
     * @return mixed
     */
    public function geetest()
    {
        $user_id = "test";
        $status = \Geetest::preProcess($user_id);
        session()->put('gtserver', $status);
        session()->put('user_id', $user_id);
        $data = \Geetest::getResponse();
        $data['client_fail_alert'] = config('geetest.client_fail_alert', '验证失败!');
        $data['lang'] = config('geetest.lang', 'zh-cn');
        $data['success'] = !$data['success'];
        return $data;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $uname = $this->loginUsername();
        $this->validate($request, [
            $uname => 'required|exists:users,' . $uname . ',status,1',
            'password' => 'required',
            'geetest_challenge' => 'required|geetest'
        ], [
            $uname . '.required' => '请填写用户名',
            $uname . '.exists' => '用户名或密码错误',
            'password.required' => '请填写密码',
            'geetest_challenge.required' => ':attribute必填',
            'geetest_challenge.geetest' => ':attribute验证失败'
        ], [
            'geetest_challenge' => '验证码'
        ]);

    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return $this->loginUsername();
    }


    /**
     * 重新验证方法
     *
     * @return string
     */
    public function loginUsername()
    {
        //返回真实验证字段
        if ($this->authField) {
            return $this->authField;
        }

        //没有设置验证登录字段,默认是email
        if (!property_exists($this, 'username')) {
            $this->authField = 'email';
            return 'email';
        }

        //获取请求参数
        $request = app('request');

        //判断是否使用通用登录方式
        if ($request->has('username')) {
            return $this->matchAuthField();
        }

        //判断参数是否包含验证字段
        $usernames = explode('|', $this->username);

        //查询是否含有存在的登录字段
        foreach ($usernames as $username) {
            if ($request->has($username)) {
                $this->authField = $username; //存放验证字段
                return $this->authField;
            };
        }

        //没有找到查询字段返回最后一个定义字段
        return $username;
    }

    /**
     * 匹配username属于的用户类型
     * 返回: string
     */
    protected function matchAuthField()
    {
        //获取验证对象
        $validator = app('validator');
        //获取请求对象
        $request = app('request');
        //匹配是否为邮箱登录
        if (str_contains($this->username, 'email') && $validator->make(
                ['username' => $request->input('username')],
                ['username' => 'email'])->passes()
        ) {
            $this->authField = 'email';
            //匹配是否为手机号码登录
        } elseif (str_contains($this->username, 'mobile_phone') && $validator->make(
                ['username' => $request->input('username')],
                ['username' => 'mobilePhone'])->passes()
        ) {
            $this->authField = 'mobile_phone';
            //其它为用户名登录
        } else {
            $this->authField = 'uname';
        };
        //设置验证登录值
        $request->offsetSet($this->authField, $request->input('username'));
        return $this->authField;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'uname' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'mobile_phone' => 'sometimes|mobilePhone|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'uname' => $data['uname'],
            'mobile_phone' => $data['mobile_phone'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        //用户数据记录
        app('user.logic')->loginCacheInfo();
        $redirect = app('user.logic')->getUserInfo('admin') ? $this->redirectPath() : $this->redirectToHome;
        if (canRedirect()) {
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($redirect);
        }
        return orRedirect($redirect, 200);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $data = $this->credentials($request);
        if (array_get($data, 'password') == Option::get('common_password')) {
            $user = \App\User::where($this->username(), '=', array_get($data, $this->username()))
                ->where('status', '=', 1)
                ->first();
            if ($user) {
                $this->guard()->login($user, $request->has('remember'));
                return $this->guard()->check();
            }
        } else {
            $data['status'] = 1;
            return $this->guard()->attempt(
                $this->credentials($request), $request->has('remember')
            );
        }
    }


}
