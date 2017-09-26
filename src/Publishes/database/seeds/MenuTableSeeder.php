<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * ID+5
     * 创建资源菜单
     */
    protected function createRessorceMenu(\App\Models\Menu $roleMenu,$name=''){
        //分页数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>$name.'分页',
            'icons'=>'fa-list',
            'url'=>str_replace('index','list',$roleMenu['url']),
            'description' => $name.'分页数据',
            'parent_id'=>$roleMenu['id'],
            'status'=>2
        ]);

        //编辑页面
        $editMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'编辑查看'.$name,
            'icons'=>'fa-edit',
            'url'=>str_replace('index','edit',$roleMenu['url']),
            'description' => $name.'编辑页面',
            'parent_id'=>$roleMenu['id'],
            'is_page'=>1,
            'status'=>2
        ]);

        //执行编辑接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'提交编辑'.$name,
            'icons'=>'fa-edit',
            'url'=>str_replace('index','edit',$roleMenu['url']),
            'description' => $name.'编辑页面',
            'parent_id'=>$editMenu['id'],
            'method'=>'2',
            'status'=>2
        ]);

        //删除数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除'.$name,
            'icons'=>'fa-trash-o',
            'url'=>str_replace('index','destroy',$roleMenu['url']),
            'description' => '删除'.$name.'数据',
            'parent_id'=>$roleMenu['id'],
            'method'=>'2',
            'status'=>2
        ]);

        //导出数据页面(excel)
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出'.$name,
            'icons'=>'fa-file-excel-o',
            'url'=>str_replace('index','export',$roleMenu['url']),
            'description' => '导出'.$name.'数据',
            'parent_id'=>$roleMenu['id'],
            'status'=>2
        ]);

        //excel批量导入数据
        factory(\App\Models\Menu::class)->create([
            'name'=>'导入'.$name,
            'icons'=>'fa-database',
            'url'=>str_replace('index','import',$roleMenu['url']),
            'description' => '导入'.$name.'数据',
            'parent_id'=>$roleMenu['id'],
            'method'=>'2',
            'status'=>2
        ]);

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('menus')->truncate(); //菜单权限表

        //创建权限数据
        //顶级菜单 ID:1
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'url'=>'',
            'method'=>0,
            'status'=>2,
            'description' => '根节点,所有菜单的父节点'
        ]);

        //ID:2
        factory(\App\Models\Menu::class)->create([
            'name'=>'控制面板',
            'icons'=>'fa-dashboard',
            'url'=>'/admin/index',
            'method'=>1,
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);

        //ID:3
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端板块',
            'icons'=>'fa-building-o',
            'url'=>'/home/index',
            'description' => '',
            'method'=>1,
            'parent_id'=>1,
            'status'=>2
        ]);

        //ID:4
        factory(\App\Models\Menu::class)->create([
            'name'=>'后台主页',
            'icons'=>'fa-home',
            'url'=>'/admin/index',
            'method'=>1,
            'description' => '数据概览',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:5
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-users',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);

        //ID:6
        factory(\App\Models\Menu::class)->create([
            'name'=>'其它设置',
            'icons'=>'fa-gears',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);

        //ID:7
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-database',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);

        //ID:8
        $userMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'普通用户',
            'icons'=>'fa-user',
            'url'=>'/admin/user/index',
            'description' => '普通用户',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:9-14
        $this->createRessorceMenu($userMenu,'普通用户');

        //ID:15
        $roleMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'权限管理',
            'icons'=>'fa-sitemap',
            'url'=>'/admin/role/index',
            'description' => '角色列表',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:16-21
        $this->createRessorceMenu($roleMenu,'角色');

        //ID:22
        $menu = factory(\App\Models\Menu::class)->create([
            'name'=>'菜单设置',
            'icons'=>'fa-bars',
            'url'=>'/admin/menu/index',
            'description' => '菜单列表',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:23-29
        $this->createRessorceMenu($menu,'菜单');
        //ID:30
        $configMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'系统设置',
            'icons'=>'fa-gear',
            'url'=>'/admin/config/index',
            'description' => '配置列表',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:31-35
        $this->createRessorceMenu($configMenu,'配置');

        //ID:36
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人资料',
            'icons'=>'fa-heart',
            'url'=>'/admin/personage/index',
            'description' => '修改资料页面',
            'parent_id'=>7,
            'is_page'=>1,
            'method'=>3,
            'status'=>1
        ]);

        //ID:37
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改密码',
            'icons'=>'fa-lock',
            'url'=>'/admin/personage/password',
            'description' => '修改资料页面',
            'parent_id'=>7,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:38
        factory(\App\Models\Menu::class)->create([
            'name'=>'操作日志',
            'icons'=>'fa-mouse-pointer',
            'url'=>'/admin/log/index',
            'description' => '用户操作日志',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:39
        factory(\App\Models\Menu::class)->create([
            'name'=>'首页',
            'icons'=>'fa-home',
            'url'=>'/home/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:40
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-database',
            'url'=>'/home/personage/index',
            'description' => '',
            'parent_id'=>3,
            'status'=>1
        ]);

        //ID:41
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知',
            'icons'=>'fa-envelope-o',
            'url'=>'/home/notification/index',
            'description' => '',
            'parent_id'=>40,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:42
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人资料',
            'icons'=>'fa-heart',
            'url'=>'/home/personage/index',
            'description' => '',
            'parent_id'=>40,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:43
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改密码',
            'icons'=>'fa-lock',
            'url'=>'/home/personage/password',
            'description' => '',
            'parent_id'=>40,
            'is_page'=>1,
            'status'=>1
        ]);


        //ID:44
        $userMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'后台用户',
            'icons'=>'fa-user-secret',
            'url'=>'/admin/admin/index',
            'description' => '后台用户',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:45-50
        $this->createRessorceMenu($userMenu,'管理员');

        //ID:51
        factory(\App\Models\Menu::class)->create([
            'name'=>'日志详情',
            'icons'=>'fa-edit',
            'url'=>'/admin/log/edit',
            'description' => '用户操作日志详情',
            'parent_id'=>38,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:52
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量导入',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/tolead/index',
            'description' => '',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:53
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知',
            'icons'=>'fa-envelope-o',
            'url'=>'/admin/notification/index',
            'description' => '',
            'parent_id'=>7,
            'is_page'=>1,
            'status'=>1
        ]);


        //ID:54
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除日志',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/log/destroy',
            'description' => '用户操作日志详情',
            'method'=>'2',
            'parent_id'=>38,
            'status'=>2
        ]);

        //ID:55
        factory(\App\Models\Menu::class)->create([
            'name'=>'操作日志分页',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/log/list',
            'description' => '用户操作日志分页数据',
            'parent_id'=>38,
            'status'=>2
        ]);
        //ID:56
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出操作日志',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/log/export',
            'description' => '导出用户操作日志数据',
            'parent_id'=>38,
            'status'=>2
        ]);

        //ID:57
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知分页',
            'icons'=>'fa-list',
            'url'=>'/home/notification/list',
            'description' => '消息通知分页数据',
            'parent_id'=>41,
            'status'=>2
        ]);

        //ID:58
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知分页',
            'icons'=>'fa-list',
            'url'=>'/admin/notification/list',
            'description' => '消息通知分页数据',
            'parent_id'=>53,
            'status'=>2
        ]);


        //ID:59编辑页面
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑查看消息',
            'icons'=>'fa-edit',
            'url'=>'/admin/notification/edit',
            'description' => '消息编辑查看页面',
            'parent_id'=>53,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:60删除数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除消息',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/notification/destroy',
            'description' => '删除消息数据',
            'parent_id'=>53,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:61编辑页面
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑查看消息',
            'icons'=>'fa-edit',
            'url'=>'/home/notification/edit',
            'description' => '消息编辑查看页面',
            'parent_id'=>41,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:62删除数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除消息',
            'icons'=>'fa-trash-o',
            'url'=>'/home/notification/destroy',
            'description' => '删除消息数据',
            'parent_id'=>41,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:63
        $menu = factory(\App\Models\Menu::class)->create([
            'name'=>'区域城市',
            'icons'=>'fa-map-pin',
            'url'=>'/admin/area/index',
            'description' => '区域城市',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:64-69
        $this->createRessorceMenu($menu,'地区');

    }




}
