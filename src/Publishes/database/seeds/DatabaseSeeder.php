<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ConfigTableSeeder::class); //系统配置安装
        $this->call(AreaTableSeeder::class); //城市区域数据
        $this->call(MenuTableSeeder::class); //菜单数据安装
        $this->call(RoleTableSeeder::class); //角色数据安装
        $this->call(MenuRoleTableSeeder::class); //角色对应菜单安装
        $this->call(UserTableSeeder::class); //初始用户安装
        $this->call(AdminTableSeeder::class); //初始后台用户安装
        $this->call(AdminRoleTableSeeder::class); //后台用户添加角色安装

        $this->call(NotificationTableSeeder::class); //初始消息安装






    }
}
