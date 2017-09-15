<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;
use LaravelAdmin\Facades\UserLogic;

class PersonageController extends Controller
{
    /**
     * 个人资料页面
     * @return mixed
     */
    public function index()
    {
        $main = app('user.logic')->getUser();
        $member = $main->member;
        //个人资料
        $data['row'] = [
            'name'=>$main['name'],
            'email'=>$main['email'],
            'mobile_phone'=>$main['mobile_phone'],
            'member'=>[
                'card'=>array_get($member,'card',''),
                'card_name'=>array_get($member,'card_name',''),
                'bank_addr'=>array_get($member,'bank_addr',''),
                'bank_id'=>array_get($member,'bank_id',0)
            ]
        ];
        $data['configUrl'] = [
            'editUrl'=>'/home/personage/index', //执行修改
            'backUrl'=>''
        ];
        return Response::returns($data);
    }

    /**
     * 修改密码页面
     * @return mixed
     */
    public function password()
    {
        return Response::returns([
            'row' => [
                'old_password' => '', //旧密码
                'password' => '', //新密码
                'password_confirmation' => '' //确认新密码
            ],
            'configUrl' => [
                'editUrl'=>'/home/personage/password', //执行修改
                'backUrl'=>'/'.getModule().'/index'
            ]
        ]);
    }

    /**
     * 执行页面修改
     * @param ValidateRequest $request
     * @return array
     */
    public function postPassword(ValidateRequest $request){
        $this->validate($request,$this->getValidateRestPasswordRule());
        $user = app('user.logic')->getUser();
        $user->update(['password'=> $request->input('password')]);
        return ['alert'=>alert(['message'=>'修改密码成功!'])];
    }

    /**
     * 修改密码重置验证
     * 返回: array
     */
    protected function getValidateRestPasswordRule(){
        return [
            'old_password'=>'required|ckeck_password',
            'password'=>'required|between:6,18|confirmed'
        ];
    }

    protected function getValidateIndexRule(){
        $user = app('user.logic')->getUser();
        return [
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email,'.$user['id'].',id,deleted_at,NULL',
            'mobile_phone' => 'sometimes|required|mobile_phone|unique:users,mobile_phone,'.$user['id'].',id,deleted_at,NULL',
        ];
    }

    /**
     * 修改个人资料
     */
    public function postIndex(\Illuminate\Http\Request $request){
        $this->validate($request, $this->getValidateIndexRule());//验证数据
        $user = app('user.logic')->getUser();
        $user->update($request->all()); //修改个人资料
        $res = $user->member->update($request->input('member'));
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '修改失败!'], 500)]);
        }
        return Response::returns(['alert' => alert(['message' => '修改成功!'])]);
    }


}
