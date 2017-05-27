<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
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
            'status'=>2,
            'description' => '根节点,所有菜单的父节点'
        ]);

        //ID:2
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人业务',
            'icons'=>'fa-home',
            'url'=>'/home/index',
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);

        //ID:3
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队管理',
            'icons'=>'fa-dashboard',
            'url'=>'/admin/index',
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);


        //ID:4
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人主页',
            'icons'=>'fa-home',
            'url'=>'/home/index',
            'description' => '',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:5
        factory(\App\Models\Menu::class)->create([
            'name'=>'佣金查询',
            'icons'=>'fa-credit-card',
            'url'=>'/home/bill/index',
            'description' => '',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:6
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-database',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);

        //ID:7
        factory(\App\Models\Menu::class)->create([
            'name'=>'我的团队',
            'icons'=>'fa-users',
            'url'=>'/home/recommend/index',
            'description' => '',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);
        \App\Models\Menu::find(7)->moveNear(6);

        //ID:8
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改资料',
            'icons'=>'fa-database',
            'url'=>'/home/personage/index',
            'description' => '',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:9
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改密码',
            'icons'=>'fa-lock',
            'url'=>'/home/password/index',
            'description' => '',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:10
        factory(\App\Models\Menu::class)->create([
            'name'=>'佣金明细',
            'icons'=>'fa-credit-card',
            'url'=>'',
            'description' => '',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:11
        factory(\App\Models\Menu::class)->create([
            'name'=>'保险险种',
            'icons'=>'fa-cubes',
            'url'=>'/home/product/index',
            'description' => '',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:12
        factory(\App\Models\Menu::class)->create([
            'name'=>'保险公司',
            'icons'=>'fa-compass',
            'url'=>'/home/firm/index',
            'description' => '',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:13
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队概览',
            'icons'=>'fa-bar-chart-o',
            'url'=>'/admin/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:14
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账明细',
            'icons'=>'fa-cny',
            'url'=>'/admin/order/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:15
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-users',
            'url'=>'',
            'description' => '',
            'parent_id'=>3,
            'status'=>1
        ]);

        //ID:16
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队管理',
            'icons'=>'fa-group',
            'url'=>'/admin/team/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>15,
            'status'=>1
        ]);

        //ID:17
        factory(\App\Models\Menu::class)->create([
            'name'=>'员工管理',
            'icons'=>'fa-user-plus',
            'url'=>'/admin/member/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>15,
            'status'=>2
        ]);

        //ID:18
        factory(\App\Models\Menu::class)->create([
            'name'=>'权限管理',
            'icons'=>'fa-sitemap',
            'url'=>'/admin/role/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>15,
            'status'=>1
        ]);

        //ID:19
        factory(\App\Models\Menu::class)->create([
            'name'=>'登录用户',
            'icons'=>'fa-user',
            'url'=>'/admin/user/index',
            'description' => '',
            'parent_id'=>15,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:20
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种管理',
            'icons'=>'fa-cubes',
            'url'=>'',
            'description' => '',
            'parent_id'=>3,
            'status'=>1
        ]);

        //ID:21
        factory(\App\Models\Menu::class)->create([
            'name'=>'保险公司',
            'icons'=>'fa-flickr',
            'url'=>'/admin/firm/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>20,
            'status'=>1
        ]);

        //ID:22
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种列表',
            'icons'=>'fa-cubes',
            'url'=>'/admin/product/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>20,
            'status'=>1
        ]);

        //ID:23
        factory(\App\Models\Menu::class)->create([
            'name'=>'交费年期',
            'icons'=>'fa-calendar-times-o',
            'url'=>'/admin/year/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>20,
            'status'=>1
        ]);

        //ID:24
        factory(\App\Models\Menu::class)->create([
            'name'=>'支付模式',
            'icons'=>'fa-credit-card',
            'url'=>'/admin/pmodel/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>20,
            'status'=>2
        ]);

        //ID:25
        factory(\App\Models\Menu::class)->create([
            'name'=>'其它设置',
            'icons'=>'fa-qrcode',
            'url'=>'',
            'description' => '',
            'parent_id'=>3,
            'status'=>1
        ]);

        //ID:26
        factory(\App\Models\Menu::class)->create([
            'name'=>'银行管理',
            'icons'=>'fa-bank ',
            'url'=>'/admin/bank/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>25,
            'status'=>1
        ]);

        //ID:27
        factory(\App\Models\Menu::class)->create([
            'name'=>'系统设置',
            'icons'=>'fa-qrcode',
            'url'=>'/admin/config/index',
            'description' => '',
            'parent_id'=>25,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:28
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户推荐列表',
            'icons'=>'',
            'url'=>'/home/recommend/list',
            'description' => '',
            'parent_id'=>9,
            'status'=>2
        ]);

        //ID:29
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量导入',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/tolead/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>25,
            'status'=>1
        ]);

        //ID:30
        factory(\App\Models\Menu::class)->create([
            'name'=>'银行翻页',
            'icons'=>'',
            'url'=>'/admin/bank/list',
            'description' => '',
            'parent_id'=>26,
            'status'=>1
        ]);

        //ID:31
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑银行',
            'icons'=>'fa-edit',
            'url'=>'/admin/bank/edit',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>26,
            'status'=>1
        ]);

        //ID:32
        factory(\App\Models\Menu::class)->create([
            'name'=>'系统设置翻页',
            'icons'=>'',
            'url'=>'/admin/config/list',
            'description' => '',
            'parent_id'=>27,
            'status'=>1
        ]);

        //ID:33
        factory(\App\Models\Menu::class)->create([
            'name'=>'系统设置编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/config/edit',
            'description' => '',
            'parent_id'=>27,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:34
        factory(\App\Models\Menu::class)->create([
            'name'=>'合作公司翻页',
            'icons'=>'',
            'url'=>'/home/firm/list',
            'description' => '',
            'parent_id'=>12,
            'status'=>1
        ]);

        //ID:35
        factory(\App\Models\Menu::class)->create([
            'name'=>'代理险种分页',
            'icons'=>'',
            'url'=>'/home/product/list',
            'description' => '',
            'parent_id'=>11,
            'status'=>1
        ]);

        //ID:36
        factory(\App\Models\Menu::class)->create([
            'name'=>'佣金明细分页',
            'icons'=>'fa-credit-card',
            'url'=>'/home/bill/list',
            'description' => '',
            'parent_id'=>5,
            'status'=>2
        ]);

        //ID:37
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除银行',
            'icons'=>'',
            'url'=>'/admin/bank/destroy',
            'description' => '',
            'parent_id'=>26,
            'status'=>1
        ]);

        //ID:38
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队管理分页',
            'icons'=>'fa-group',
            'url'=>'/admin/team/list',
            'description' => '',
            'parent_id'=>16,
            'status'=>1
        ]);

        //ID:39
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队管理编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/team/edit',
            'description' => '',
            'parent_id'=>16,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:40
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除团队',
            'icons'=>'',
            'url'=>'/admin/team/destroy',
            'description' => '',
            'parent_id'=>16,
            'status'=>1
        ]);

        //ID:41
        factory(\App\Models\Menu::class)->create([
            'name'=>'成员分页',
            'icons'=>'',
            'url'=>'/admin/member/list',
            'description' => '',
            'parent_id'=>17,
            'status'=>1
        ]);

        //ID:42
        factory(\App\Models\Menu::class)->create([
            'name'=>'成员编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/member/edit',
            'description' => '',
            'parent_id'=>17,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:43
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除成员',
            'icons'=>'',
            'url'=>'/admin/member/destroy',
            'description' => '',
            'parent_id'=>17,
            'status'=>1
        ]);

        //ID:44
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色分页',
            'icons'=>'',
            'url'=>'/admin/role/list',
            'description' => '',
            'parent_id'=>18,
            'status'=>1
        ]);

        //ID:45
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/role/edit',
            'description' => '',
            'parent_id'=>18,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:46
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除角色',
            'icons'=>'',
            'url'=>'/admin/role/destroy',
            'description' => '',
            'parent_id'=>18,
            'status'=>1
        ]);

        //ID:47
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户分页',
            'icons'=>'',
            'url'=>'/admin/user/list',
            'description' => '',
            'parent_id'=>19,
            'status'=>1
        ]);

        //ID:48
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑用户',
            'icons'=>'fa-edit',
            'url'=>'/admin/user/edit',
            'description' => '',
            'parent_id'=>19,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:49
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除用户',
            'icons'=>'',
            'url'=>'/admin/user/destroy',
            'description' => '',
            'parent_id'=>19,
            'status'=>1
        ]);

        //ID:50
        factory(\App\Models\Menu::class)->create([
            'name'=>'品牌分页',
            'icons'=>'',
            'url'=>'/admin/firm/list',
            'description' => '',
            'parent_id'=>21,
            'status'=>1
        ]);

        //ID:51
        factory(\App\Models\Menu::class)->create([
            'name'=>'品牌编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/firm/edit',
            'description' => '',
            'parent_id'=>21,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:52
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除品牌',
            'icons'=>'',
            'url'=>'/admin/firm/destroy',
            'description' => '',
            'parent_id'=>21,
            'status'=>1
        ]);

        //ID:53
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种分页',
            'icons'=>'',
            'url'=>'/admin/product/list',
            'description' => '',
            'parent_id'=>22,
            'status'=>1
        ]);

        //ID:54
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/product/edit',
            'description' => '',
            'parent_id'=>22,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:55
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除险种',
            'icons'=>'',
            'url'=>'/admin/product/destroy',
            'description' => '',
            'parent_id'=>22,
            'status'=>1
        ]);

        //ID:56
        factory(\App\Models\Menu::class)->create([
            'name'=>'年期分页',
            'icons'=>'',
            'url'=>'/admin/year/list',
            'description' => '',
            'parent_id'=>23,
            'status'=>1
        ]);

        //ID:57
        factory(\App\Models\Menu::class)->create([
            'name'=>'年期编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/year/edit',
            'description' => '',
            'parent_id'=>23,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:58
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除年期',
            'icons'=>'',
            'url'=>'/admin/year/destroy',
            'description' => '',
            'parent_id'=>23,
            'status'=>1
        ]);

        //ID:59
        factory(\App\Models\Menu::class)->create([
            'name'=>'支付方式分页',
            'icons'=>'',
            'url'=>'/admin/pmodel/list',
            'description' => '',
            'parent_id'=>24,
            'status'=>1
        ]);

        //ID:60
        factory(\App\Models\Menu::class)->create([
            'name'=>'支付方式编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/pmodel/edit',
            'description' => '',
            'parent_id'=>24,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:61
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除支付方式',
            'icons'=>'',
            'url'=>'/admin/pmodel/destroy',
            'description' => '',
            'parent_id'=>24,
            'status'=>1
        ]);

        //ID:62
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账分页',
            'icons'=>'',
            'url'=>'/admin/order/list',
            'description' => '',
            'parent_id'=>14,
            'status'=>2
        ]);

        //ID:63
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/order/edit',
            'description' => '',
            'parent_id'=>14,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:64
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除台账',
            'icons'=>'',
            'url'=>'/admin/order/destroy',
            'description' => '',
            'parent_id'=>14,
            'status'=>2
        ]);

        //ID:65
        factory(\App\Models\Menu::class)->create([
            'name'=>'查询推荐人',
            'icons'=>'fa-edit',
            'url'=>'/admin/user/recommends',
            'description' => '',
            'parent_id'=>48,
            'status'=>2
        ]);

        //ID:66
        factory(\App\Models\Menu::class)->create([
            'name'=>'查询连带责任人',
            'icons'=>'fa-edit',
            'url'=>'/admin/user/rusers',
            'description' => '',
            'parent_id'=>48,
            'status'=>2
        ]);

        //ID:67
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户导出',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/user/export',
            'description' => '',
            'parent_id'=>19,
            'is_page'=>2,
            'status'=>2
        ]);

        //ID:68
        factory(\App\Models\Menu::class)->create([
            'name'=>'审核台账',
            'icons'=>'fa-edit',
            'url'=>'/admin/order/update-valid',
            'description' => '',
            'parent_id'=>14,
            'status'=>2
        ])->delete();

        //ID:69
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改用户状态',
            'icons'=>'fa-edit',
            'url'=>'/admin/user/update-status',
            'description' => '',
            'parent_id'=>48,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:70
        factory(\App\Models\Menu::class)->create([
            'name'=>'设置高级职级',
            'icons'=>'fa-edit',
            'url'=>'/admin/user/set-senior-rank',
            'description' => '',
            'parent_id'=>48,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:71
        factory(\App\Models\Menu::class)->create([
            'name'=>'审核台账',
            'icons'=>'fa-edit',
            'url'=>'/admin/order/update-valid',
            'description' => '',
            'parent_id'=>14,
            'status'=>2
        ]);

        //ID:72
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账状态修改',
            'icons'=>'fa-edit',
            'url'=>'/admin/order/update-status',
            'description' => '',
            'parent_id'=>63,
            'status'=>2
        ]);

        //ID:73
        factory(\App\Models\Menu::class)->create([
            'name'=>'管理津贴',
            'icons'=>'fa-cubes',
            'url'=>'/admin/bill/index',
            'description' => '',
            'is_page'=>1,
            'parent_id'=>3,
            'status'=>1
        ]);

        \App\Models\Menu::find(73)->moveNear(14);

        //ID:74
        factory(\App\Models\Menu::class)->create([
            'name'=>'管理津贴分页',
            'icons'=>'',
            'url'=>'/admin/bill/list',
            'description' => '',
            'parent_id'=>73,
            'status'=>2
        ]);

        //ID:75
        factory(\App\Models\Menu::class)->create([
            'name'=>'管理津贴编辑',
            'icons'=>'fa-edit',
            'url'=>'/admin/bill/edit',
            'description' => '',
            'parent_id'=>73,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:76
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除管理津贴',
            'icons'=>'',
            'url'=>'/admin/bill/destroy',
            'description' => '',
            'parent_id'=>73,
            'status'=>2
        ]);

        //ID:77
        factory(\App\Models\Menu::class)->create([
            'name'=>'保单查询',
            'icons'=>'fa-users',
            'url'=>'/home/order/index',
            'description' => '',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);
        \App\Models\Menu::find(77)->moveNear(4,'after');

        //ID:78
        factory(\App\Models\Menu::class)->create([
            'name'=>'保单查询分页',
            'icons'=>'',
            'url'=>'/home/order/list',
            'description' => '',
            'parent_id'=>77,
            'status'=>2
        ]);

        //ID:79
        factory(\App\Models\Menu::class)->create([
            'name'=>'保单查询查看',
            'icons'=>'fa-edit',
            'url'=>'/home/order/show',
            'description' => '',
            'parent_id'=>77,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:80
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队业绩',
            'icons'=>'fa-edit',
            'url'=>'/admin/team-order/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        \App\Models\Menu::find(80)->moveNear(13,'after');

        //ID:81
        factory(\App\Models\Menu::class)->create([
            'name'=>'团队业绩翻页',
            'icons'=>'fa-edit',
            'url'=>'/admin/team-order/list',
            'description' => '',
            'parent_id'=>80,
            'status'=>2
        ]);




    }

    /**
     * 创建资源路由
     */
    public function seedResource(){

    }
}
