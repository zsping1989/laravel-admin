<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('configs')->truncate(); //系统配置表

        //系统用户通用密码
        factory(\App\Models\Config::class)->create([
            'key'=>'common_password',
            'name'=>'通用密码配置',
            'description'=>'所有用户通用密码,请设置相对复杂密码',
            'value'=>config('app.admin_password')
        ]);

        //创建用户默认密码
        factory(\App\Models\Config::class)->create([
            'key'=>'default_password',
            'name'=>'默认密码配置',
            'description'=>'默认密码配置',
            'value'=>'123456'
        ]);



    }
}
