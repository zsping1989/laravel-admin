<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    protected $bindModel='App\User';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('users')->truncate(); //用户表

        //ID:1 创建一个超级管理员用户
        factory(\App\User::class)->create([
            'uname'=>config('app.admin_user_name'),
            'name'=>str_replace('业务系统','',config('app.name')),
            'password'=>bcrypt(strval(config('app.admin_password'))),
            'mobile_phone'=>13699411148,
            'qq'=>214986304,
            'email'=>'214986304@qq.com',
            'status'=>1
        ]);
    }
}
