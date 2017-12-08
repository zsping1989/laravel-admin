<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Ouser;
use App\Models\User;
use Germey\Geetest\GeetestCaptcha;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
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
    use GeetestCaptcha;
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

    //三方登录配置
    protected $otherLogin=[
        ['type'=>'qq','url'=>'/open/other-login/qq','class'=>'hover-primary'],
        ['type'=>'wechat','url'=>'/open/other-login/weixin','class'=>'hover-warning'],
        ['type'=>'weibo','url'=>'/open/other-login/weibo','class'=>'hover-danger']
    ];


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
     * 三方登录
     * @return mixed
     */
    public function otherLogin($type){
        return Socialite::with($type)->redirect();
    }

    /**
     * 三方登录后回调
     * @return mixed
     */
    public function otherLoginCallback(Request $request,$type){
        $ouser = collect(Socialite::driver($type)->user());
        //三方登录类型
        $ouser_type = Ouser::getFieldsMap('type')->flip()->get($type,0);
        //查询三方账号是否已绑定用户
        $user = User::whereHas('ousers',function($q)use($ouser_type,$ouser){
            $q->where('type',$ouser_type)->where('open_id',array_get($ouser,'id'));
        })->first();
        if($user){ //直接登录
            $this->guard()->login($user);
            return $this->sendLoginResponse($request);
        }else{ //没有账号,保存三方信息
            Ouser::firstOrCreate([
                'type'=>$ouser_type,
                'open_id'=>array_get($ouser,'id')
            ],[
                'user_id'=>0,
                'type'=>$ouser_type,
                'open_id'=>array_get($ouser,'id'),
                'data'=>array_get($ouser,'user')
            ]);
            session()->put(config('session.other_login.key'),$ouser_type.'|'.array_get($ouser,'id'));
            return orRedirect(route('login',['other'=>md5($ouser_type.'|'.array_get($ouser,'id'))]));
        }
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
        $login_num = $this->getLoginFailedNum();
        return Response::returns([
            'verify' => config('app.verify.type')=='captcha' ? $this->captcha() : $this->geetest(),
            'other'=>\Illuminate\Support\Facades\Request::get('other',''), //三方信息数据
            'other_login'=>$this->otherLogin,
            'must_verify'=>$login_num>=config('app.verify.login_pass_num'),
            'communication_mode'=>config('app.communication_mode')
        ]);
    }

    /**
     * 极验验证
     * @return array
     */
    public function geetest()
    {
        /*$user_id = "test";
        $status = \Geetest::preProcess(['gt'=>$user_id]);
        session()->put('gtserver', $status);
        session()->put('user_id', $user_id);
        $data = \Geetest::getResponse();
        $data['success'] = !$data['success'];*/
        return [
            'type'=>'geetest',
            'dataUrl'=>'/open/geetest',
            'data'=>[
                'client_fail_alert'=>config('geetest.client_fail_alert', '验证失败!'),
                'lang'=>config('geetest.lang', 'zh-cn'),
                'product'=>'float',
                'http'=>'http://'
            ]
        ];
    }

    /**
     * 图片验证码
     * @return array
     */
    public function captcha(){
        return [
            'type'=>'captcha',
            'dataUrl'=> captcha_src(), //验证码图片地址
            'data'=>[],
        ];
    }

    /**
     * 登录失败次数
     * 取最大的一个,防止暴力破解
     * @return mixed
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    protected function getLoginFailedNum(){
        $login_num_session = session()->get(config('session.verify.login_num_key'),0);
        $login_num_ip = Cache::get(config('cache.verify.login_num_key').':'.app('request')->getClientIp(),0); //登录失败次数
        $login_num_uname = Cache::get(config('cache.verify.login_num_key').':'.app('request')->get($this->loginUsername()),0); //登录失败次数
        return collect([$login_num_session,$login_num_uname,$login_num_ip])->max();
    }

    /**
     * 设置登录失败次数
     * @param $login_num
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    protected function setLoginFailedNum($login_num){
        session()->put(config('session.verify.login_num_key'),$login_num); //session记录登录失败次数
        $login_num and Cache::put(config('cache.verify.login_num_key').':'.app('request')->getClientIp(),$login_num,600); //ip记录登录失败次数
        Cache::put(config('cache.verify.login_num_key').':'.app('request')->get($this->loginUsername()),$login_num); //用户名记录失败次数
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
        $request->offsetSet('geetest_challenge', $request->input('verify'));
        $validate = [
            $uname => 'required|exists:users,' . $uname . ',status,1',
            'password' => 'required'
        ];
        $login_num = $this->getLoginFailedNum();
        if($login_num>=config('app.verify.login_pass_num')){
            $validate['verify'] = 'required|'.config('app.verify.type');
        }
        $login_num++;
        $this->setLoginFailedNum($login_num);
        $this->validate($request,$validate , [
            $uname . '.required' => '请填写用户名',
            $uname . '.exists' => '用户名或密码错误',
            'password.required' => '请填写密码',
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'verify' => '验证码'
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
                ['username' => 'mobile_Phone'])->passes()
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
            'mobile_phone' => 'sometimes|mobile_phone|unique:users',
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
        $this->setLoginFailedNum(0);
        //如果是登录并绑定
        $other = \Illuminate\Support\Facades\Request::get('other');
        $session_other = session()->get(config('session.other_login.key'));
        if($other && md5($session_other)==$other){
            $session_others = explode('|',$session_other);
            //查询三方数据
            Ouser::where('type',array_get($session_others,0))
                ->where('open_id',array_get($session_others,1))
                ->where('user_id',0)
                ->update(['user_id'=>array_get(Auth::user(),'id')]);
        }
        $redirect = app('user.logic')->getUserInfo('admin') ? $this->redirectPath() : $this->redirectToHome;
        if (canRedirect()) {
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect($redirect,302);
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
