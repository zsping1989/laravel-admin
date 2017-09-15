<?php

use Illuminate\Database\Seeder;
use \App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        DB::table('menu_role')->truncate(); //角色权限关联表
        $home_menu = Menu::find(3);
        \App\Models\Role::find(1)->menus()->saveMany(
            \App\Models\Menu::optionalParent($home_menu)->get()->all()
        );

    }
}
