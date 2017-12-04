<?php

namespace App\Http\Controllers\Open;

use App\Jobs\SendSms;
use App\Mail\RegisterUser;
use App\Models\Ouser;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use LaravelAdmin\Facades\SMS;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    protected $redirectTo = '/admin/index';
    protected $redirectAfterLogout = '/open/login';
    protected $redirectToHome = '/home/index';
    protected $emailActivateTime = 3600; //注册邮箱激活失效时间


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('activateByEmail');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = [
            'uname' => 'required|alpha_dash|between:6,18|unique:users,uname', //用户名
            'password' => 'required|string|min:6|confirmed', //密码
            'password_confirmation' => 'required', //确认密码
            'agree' => 'accepted'
        ];
        //电子邮箱
        if (array_get($data, 'model') == 'email') {
            $validator['email'] = 'required|string|email|max:255|unique:users,email'; //电子邮箱
            $validator['verify'] = 'required|'.config('app.verify.type'); //极验验证
        } else {
            $validator['mobile_phone'] = 'required|mobile_phone|unique:users,mobile_phone'; //手机号
        }
        return Validator::make($data, $validator, [
            'uname.unique' => '用户名已存在',
            'email.unique' => '电子邮箱已被使用了',
            'mobile_phone.mobile_phone' => '请正确填写手机号',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'uname' => '用户名',
            'email' => '电子邮箱',
            'mobile_phone' => '手机号',
            'verify'=>'验证码'
        ]);
    }

    protected function validatorSms(Request $request)
    {
        $this->validate($request, [
            'mobile_phone' => 'required|mobile_phone', //手机号
            'verify' => 'required|'.config('app.verify.type') //验证码
        ], [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'verify' => '验证码'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $model = \Illuminate\Support\Facades\Request::get('model');
        if ($model == 'email') {
            $data['status'] = 0; //电子邮箱注册需要激活
        } else {
            $data['status'] = 1; //短信注册直接激活用户
        }
        //三方绑定账号
        $other = \Illuminate\Support\Facades\Request::get('other');
        $session_other = session()->get(config('session.other_login.key'));
        $ouser = null;
        if ($other && md5($session_other) == $other) {
            $session_others = explode('|', $session_other);
            //查询三方数据
            $ouser = Ouser::where('type', array_get($session_others, 0))
                ->where('open_id', array_get($session_others, 1))
                ->where('user_id', 0)
                ->first();
            if ($ouser) {
                $data['name'] = array_get($ouser, 'data.nickname'); //三方用户名昵称
            }
        }
        $user = User::create($data);
        if ($ouser) {
            $ouser->update(['user_id' => array_get($user, 'id')]);
        }
        //发送电子邮件
        if ($model == 'email') {
            $this->sendEmail($user);
        }
        return $user;
    }

    protected function sendEmail(User $user)
    {
        $url = route('activate', ['key' => md5($user['uname'] . '|' . $user['created_at']), 'id' => $user['id']]);
        Mail::to($user['email'])->queue((new RegisterUser($user, $url))
            ->onQueue('register_email'));
    }

    /**
     * 发送短信
     */
    public function sendSMS(Request $request)
    {
        //极验验证
        $request->offsetSet('geetest_challenge', $request->input('verify'));
        //验证码及上传验证码发送时间
        $codes = session()->get(config('session.sms.code_key'), []);
        $now = time();
        if (count(array_get($codes, 'values')) >= config('session.sms.refuse_num', 1) && array_get($codes,'time') + config('session.sms.refuse_time') > $now) {
            return Response::returns([
                'message' => '拒绝发送短信',
                'errors' => [
                    'mobile_phone_code' => ['你操作太频繁,请稍后再试']
                ]
            ], 422);
        }
        //正在发送短信验证码
        if ($codes && array_get($codes,'time') + config('session.sms.forbidden') > $now) {
            return Response::returns([
                'title' => '短信正在发送...',
                'countdown' => $codes['time'] + config('session.sms.forbidden') - $now
            ]);
        }

        //验证数据
        $this->validate($request, [
            'mobile_phone' => 'required|mobile_phone|unique:users,mobile_phone', //手机号
            'verify' => 'required|'.config('app.verify.type') //验证验证码
        ], [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败',
            'mobile_phone.mobile_phone' => '请正确填写手机号',
            'mobile_phone.unique' => '该手机号已经注册过了'
        ], [
            'verify' => '验证码',
            'mobile_phone' => '手机号'
        ]);

        //生成短信验证码并存放
        $code = num_random(6);
        $mobile_phone = $request->get('mobile_phone');

        $codes['time'] = $now;
        $codes['values'][] = $code . '|' . $mobile_phone;
        $codes['verify_num'] = 0; //验证次数
        session()->put(config('session.sms.code_key'), $codes);

        //短信内容
        $sms = SMS::setRecNum($mobile_phone)
            ->setSmsParam(['code' => $code])
            ->setSmsFreeSignName(config('sms.ali_dayu.signature'))
            ->setSmsTemplateCode(config('sms.ali_dayu.template_codes.register'));

        //异步队列发送短信
        $job = (new SendSms($sms))->onQueue('register_sms');
        $this->dispatch($job);
        return Response::returns([
            'title' => '短信正在发送...',
            'countdown' => config('session.sms.forbidden')
        ]);
    }

    /**
     * 注册短信验证
     */
    protected function registerValidator(){
        Validator::extend('smsCode', function($attribute, $value, $parameters){
            if(!$value) return true;
            //获取短信验证码
            $sms_codes = session()->get(config('session.sms.code_key'),[]);
            $value = $value.'|'.\Illuminate\Support\Facades\Request::get(array_get($parameters,0,''),'');
            //认证成功后直接清除前面的短信码
            if(in_array($value,array_get($sms_codes,'values',[]))){
                session()->forget(config('session.sms.code_key'));
                return true;
            }
            $sms_codes['verify_num']++;
            session()->put(config('session.sms.code_key'),$sms_codes);
            return false;
        });
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->registerValidator();
        //极验验证
        $request->offsetSet('geetest_challenge', $request->input('verify'));
        $this->validator($request->all())->validate();
        //最后验证短信码
        if ($request->get('model') != 'email') {
            Validator::make($request->all(), [
                'mobile_phone_code' => 'required|sms_code:mobile_phone' //短信验证码
            ], [
                'mobile_phone_code.sms_code' => '短信验证码验证失败'
            ], [
                'mobile_phone_code' => '短信验证码'
            ])->validate();
        }
        event(new Registered($user = $this->create($request->all())));
        if ($request->get('model') != 'email') {
            $this->guard()->login($user);
            //用户数据记录
            app('user.logic')->loginCacheInfo();
        }
        return $this->registered($request, $user)
            ?: orRedirect($this->redirectPath());
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $redirect = app('user.logic')->getUserInfo('admin') ? $this->redirectTo : $this->redirectToHome;
        return $redirect;
    }

    /**
     * 通过电子邮箱激活账户
     */
    public function activateByEmail(Request $request)
    {
        $id = $request->get('id');
        $key = $request->get('key');
        if (!$id || !$key) {
            abort(404);
        }
        $user = User::findOrFail($id);
        if (Carbon::create()->diffInSeconds($user->created_at) > $this->emailActivateTime) {
            dd('激活链接已失效');
        }
        if ($user['status'] != 0) {
            dd('你的用户已经被激活过了');
        }
        if (md5($user['uname'] . '|' . $user['created_at']) != $key) {
            abort(404);
        }
        $user->update(['status' => 1]);
        $this->guard()->login($user);
        //用户数据记录
        app('user.logic')->loginCacheInfo();
        return redirect(route('login'));
    }
}
