<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('admins')->truncate();
        //创建后台用户
        \App\Models\User::find(1)->admin()
        ->save(factory(App\Models\Admin::class)->make());
    }
}
