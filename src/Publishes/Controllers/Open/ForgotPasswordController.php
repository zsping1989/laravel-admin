<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Jobs\SendSms;
use App\Mail\ForgotPassword;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use LaravelAdmin\Facades\SMS;
use Mews\Captcha\Facades\Captcha;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    protected $characters;
    protected $code_length=5;
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->characters = config('captcha.characters','2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ');
        $this->now = time();
    }

    /**
     * Generate captcha text
     *
     * @return string
     */
    protected function generate()
    {
        $characters = str_split($this->characters);

        $bag = '';
        for($i = 0; $i < $this->code_length; $i++)
        {
            $bag .= $characters[rand(0, count($characters) - 1)];
        }
        return $bag;
    }


    protected function sendValidate(Request $request,$validate,$type='email'){
        //验证码及上传验证码发送时间
        $codes = session()->get(config('session.sms.forgot_password_key'), []);
        $now = $this->now;
        $map = ['email'=>'邮件','mobile_phone'=>'短信'];
        if (count(array_get($codes, 'values')) >= config('session.sms.refuse_num', 1) && array_get($codes,'time') + config('session.sms.refuse_time') > $now) {
            return Response::returns([
                'message' => '拒绝发送'.array_get($map,$type),
                'errors' => [
                    $type.'_code' => ['你操作太频繁,请稍后再试']
                ]
            ], 422);
        }
        //正在发送短信验证码
        if ($codes && $codes['time'] + config('session.sms.forbidden') > $now) {
            return Response::returns([
                'title' => array_get($map,$type).'正在发送...',
                'countdown' => $codes['time'] + config('session.sms.forbidden') - $now
            ]);
        }

        //极验验证
        $request->offsetSet('geetest_challenge', $request->input('verify'));
        //验证
        $this->validate($request, $validate, [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败',
            'email.exists'=>'邮箱地址错误',
            'mobile_phone.exists'=>'手机号码错误'
        ], [
            'verify' => '验证码',
            'uname'=>'用户名',
            'mobile_phone'=>'手机号码'
        ]);
    }

    /**
     *
     */
    protected function getCode(Request $request){
        //生成短信验证码并存放
        $code = $this->generate();
        $codes['time'] = $this->now;
        $codes['values'][] = $code . '|' . $request->get('uname');
        $codes['verify_num'] = 0; //验证次数
        session()->put(config('session.sms.forgot_password_key'), $codes);
        return $code;
    }



    /**
     * 发送忘记密码验证邮件
     */
    public function sendEmail(Request $request){
        $uname = \Illuminate\Support\Facades\Request::input('uname');
        $validate = [
            'uname'=>'required|exists:users,uname,deleted_at,NULL', //用户名是否存在
            'email' => 'required|email|exists:users,email,uname,'.$uname, //邮箱地址
            'verify' => 'required|'.config('app.verify.type') //验证码
        ];
        $res = $this->sendValidate($request,$validate,'email');
        if($res){
            return $res;
        }
        //发送忘记密码验证码
        $user = User::where('uname',$uname)->first();
        Mail::to($user['email'])->queue((new ForgotPassword($user, $this->getCode($request)))
            ->onQueue('forgot_password_email'));
        return Response::returns([
            'title' => '邮件正在发送...',
            'countdown' => config('session.sms.forbidden')
        ]);

    }

    /**
     * 发送忘记密码验证短信
     */
    public function sendSMS(Request $request){
        $uname = \Illuminate\Support\Facades\Request::input('uname');
        $validate = [
            'uname'=>'required|exists:users,uname,deleted_at,NULL', //用户名是否存在
            'mobile_phone' => 'required|mobile_phone|exists:users,email,uname,'.$uname, //手机号
            'verify' => 'required|'.config('app.verify.type') //验证码
        ];
        $res = $this->sendValidate($request,$validate,'mobile_phone');
        if($res){
            return $res;
        }

        $mobile_phone = $request->get('mobile_phone');
        //短信内容
        $sms = SMS::setRecNum($mobile_phone)
            ->setSmsParam(['code' => $this->getCode($request)])
            ->setSmsFreeSignName(config('sms.ali_dayu.signature'))
            ->setSmsTemplateCode(config('sms.ali_dayu.template_codes.forgot'));

        //异步队列发送短信
        $job = (new SendSms($sms))->onQueue('forgot_password_sms');
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
        Validator::extend('forgotCode', function($attribute, $value, $parameters){
            if(!$value) return true;
            //获取短信验证码
            $sms_codes = session()->get(config('session.sms.forgot_password_key'),['verify_num'=>0]);
            $value = $value.'|'.\Illuminate\Support\Facades\Request::get(array_get($parameters,0,''),'');
            //认证成功后直接清除前面的短信码
            if(in_array($value,array_get($sms_codes,'values',[]))){
                session()->forget(config('session.sms.forgot_password_key'));
                return true;
            }
            $sms_codes['verify_num']++;
            session()->put(config('session.sms.forgot_password_key'),$sms_codes);
            return false;
        });
    }

    public function resetPassword(Request $request){
        $this->registerValidator();
        //验证码及上传验证码发送时间
        $codes = session()->get(config('session.sms.forgot_password_key'), []);
        $valide = [
            'uname'=>'required|exists:users,uname,deleted_at,NULL', //用户名是否存在
            'password' => 'required|string|min:6,max:16|confirmed', //密码
            'password_confirmation' => 'required', //确认密码
        ];
        if($codes && array_get($codes,'verify_num')>config('session.sms.verify_num')){
            //极验验证
            $request->offsetSet('geetest_challenge', $request->input('verify'));
            $valide['verify'] = 'required|'.config('app.verify.type'); //验证码
        }
        //验证
        $this->validate($request, $valide, [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'verify' => '验证码',
            'uname'=>'用户名'
        ]);
        $model = $request->get('model');
        $map = ['email'=>'邮件','mobile_phone'=>'短信'];
        //最后验证短信码
        Validator::make($request->all(), [
            $model.'_code' => 'required|forgot_code:uname'
        ], [
            $model.'_code.forgot_code' => array_get($map,$model).'验证码验证失败'
        ], [
            $model.'_code' => array_get($map,$model).'验证码'
        ])->validate();
        $user = User::where('uname',$request->get('uname'))->first();
        $user->update(['password'=> $request->input('password')]);
        return orRedirect(route('login'));
    }
}
