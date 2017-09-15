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
            'name'=>'登录用户',
            'icons'=>'fa-user',
            'url'=>'/admin/user/index',
            'description' => '登录用户',
            'parent_id'=>5,
            'is_page'=>1,
            'status'=>2
        ]);
        //ID:9-14
        $this->createRessorceMenu($userMenu,'登录用户');

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
            'name'=>'代理人员',
            'icons'=>'fa-user-md',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);


        //ID:53
        $memberMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'代理人员',
            'icons'=>'fa-user-md',
            'url'=>'/admin/member/index',
            'description' => '代理人员',
            'parent_id'=>52,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:54-59
        $this->createRessorceMenu($memberMenu,'代理人');

        //ID:60
        $teamMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'代理团队',
            'icons'=>'fa-users',
            'url'=>'/admin/team/index',
            'description' => '代理团队',
            'parent_id'=>52,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:61-66
        $this->createRessorceMenu($teamMenu,'团队');

        //ID:67
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种管理',
            'icons'=>'fa-cubes',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);
        //ID:68
        $firmMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'保险公司',
            'icons'=>'fa-hand-pointer-o',
            'url'=>'/admin/firm/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:69-74
        $this->createRessorceMenu($firmMenu,'保险公司');

        //ID:75
        $classifyMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'险种分类',
            'icons'=>'fa-map',
            'url'=>'/admin/classify/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:76-81
        $this->createRessorceMenu($classifyMenu,'险种分类');

        //ID:82
        $productMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'险种列表',
            'icons'=>'fa-cubes',
            'url'=>'/admin/product/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:83-88
        $this->createRessorceMenu($productMenu,'险种');

        //ID:89
        $yearMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'交费年期',
            'icons'=>'fa-clock-o',
            'url'=>'/admin/year/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:90-95
        $this->createRessorceMenu($yearMenu,'交费年期');

        //ID:96
        $bankMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'银行管理',
            'icons'=>'fa-bank',
            'url'=>'/admin/bank/index',
            'description' => '',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:97-102
        $this->createRessorceMenu($bankMenu,'银行');

        //ID:103
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量导入',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/tolead/index',
            'description' => '',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:104
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知',
            'icons'=>'fa-envelope-o',
            'url'=>'/admin/notification/index',
            'description' => '',
            'parent_id'=>7,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:105
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账管理',
            'icons'=>'fa-list',
            'url'=>'',
            'description' => '',
            'parent_id'=>2,
            'status'=>1
        ]);


        //ID:106
        $bankMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'保单管理',
            'icons'=>'fa-newspaper-o',
            'url'=>'/admin/order/index',
            'description' => '',
            'parent_id'=>105,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:107-112
        $this->createRessorceMenu($bankMenu,'保单');

        //ID:113
        $bankMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'预期佣金',
            'icons'=>'fa-list-ul',
            'url'=>'/admin/pay/index',
            'description' => '',
            'parent_id'=>105,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:114-119
        $this->createRessorceMenu($bankMenu,'台账');

        //ID:120
        $bankMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'结算佣金',
            'icons'=>'fa-money',
            'url'=>'/admin/bill/index',
            'description' => '',
            'parent_id'=>105,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:121-126
        $this->createRessorceMenu($bankMenu,'佣金');

        //ID:127
        factory(\App\Models\Menu::class)->create([
            'name'=>'保单查询',
            'icons'=>'fa-newspaper-o',
            'url'=>'/home/order/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:128
        factory(\App\Models\Menu::class)->create([
            'name'=>'预期佣金',
            'icons'=>'fa-list-ul',
            'url'=>'/home/pay/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:129
        factory(\App\Models\Menu::class)->create([
            'name'=>'结算佣金',
            'icons'=>'fa-money',
            'url'=>'/home/bill/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:130
        factory(\App\Models\Menu::class)->create([
            'name'=>'我的团队',
            'icons'=>'fa-users',
            'url'=>'/home/member/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:131
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除日志',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/log/destroy',
            'description' => '用户操作日志详情',
            'method'=>'2',
            'parent_id'=>38,
            'status'=>2
        ]);

        //ID:132
        factory(\App\Models\Menu::class)->create([
            'name'=>'操作日志分页',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/log/list',
            'description' => '用户操作日志分页数据',
            'parent_id'=>38,
            'status'=>2
        ]);
        //ID:133
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出操作日志',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/log/export',
            'description' => '导出用户操作日志数据',
            'parent_id'=>38,
            'status'=>2
        ]);

        //ID:134
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知分页',
            'icons'=>'fa-list',
            'url'=>'/home/notification/list',
            'description' => '消息通知分页数据',
            'parent_id'=>41,
            'status'=>2
        ]);

        //ID:135
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息通知分页',
            'icons'=>'fa-list',
            'url'=>'/admin/notification/list',
            'description' => '消息通知分页数据',
            'parent_id'=>104,
            'status'=>2
        ]);

        //ID:136
        $memberMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'代理职级',
            'icons'=>'fa-user-plus',
            'url'=>'/admin/grade/index',
            'description' => '代理职级',
            'parent_id'=>52,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:137-142
        $this->createRessorceMenu($memberMenu,'代理职级');

        //ID:143编辑页面
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑查看消息',
            'icons'=>'fa-edit',
            'url'=>'/admin/notification/edit',
            'description' => '消息编辑查看页面',
            'parent_id'=>104,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:144删除数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除消息',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/notification/destroy',
            'description' => '删除消息数据',
            'parent_id'=>104,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:145编辑页面
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑查看消息',
            'icons'=>'fa-edit',
            'url'=>'/home/notification/edit',
            'description' => '消息编辑查看页面',
            'parent_id'=>41,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:146删除数据接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除消息',
            'icons'=>'fa-trash-o',
            'url'=>'/home/notification/destroy',
            'description' => '删除消息数据',
            'parent_id'=>41,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:147代理人工号获取接口
        factory(\App\Models\Menu::class)->create([
            'name'=>'代理人工号获取',
            'icons'=>'fa-search',
            'url'=>'/admin/member/job-number',
            'description' => '代理人工号获取',
            'parent_id'=>55,
            'status'=>2
        ]);

        //ID:148
        $productMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'险种年期',
            'icons'=>'fa-calendar-times-o',
            'url'=>'/admin/product-year/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:149-154
        $this->createRessorceMenu($productMenu,'险种年期');

        //ID:155
        $productMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'险种佣金率',
            'icons'=>'fa-registered',
            'url'=>'/admin/rate/index',
            'description' => '',
            'parent_id'=>67,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:156-161
        $this->createRessorceMenu($productMenu,'险种佣金率');

        //ID:162
        factory(\App\Models\Menu::class)->create([
            'name'=>'转换成佣金率表',
            'icons'=>'fa-registered',
            'url'=>'/admin/tolead/convert-to-rate',
            'description' => '',
            'method'=>'2',
            'parent_id'=>103,
            'status'=>2
        ]);

        //ID:163
        factory(\App\Models\Menu::class)->create([
            'name'=>'转换成产品表',
            'icons'=>'fa-cubes',
            'url'=>'/admin/tolead/convert-to-product',
            'description' => '',
            'method'=>'2',
            'parent_id'=>103,
            'status'=>2
        ]);

        //ID:164
        $bankMenu = factory(\App\Models\Menu::class)->create([
            'name'=>'已购保险',
            'icons'=>'fa-outdent',
            'url'=>'/admin/order-product/index',
            'description' => '',
            'parent_id'=>105,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:165-170
        $this->createRessorceMenu($bankMenu,'已购保险');
        //ID:171 创建订单险种查询权限
        factory(\App\Models\Menu::class)->create([
            'name'=>'险种查询',
            'icons'=>'fa-cubes',
            'url'=>'/admin/product/search',
            'description' => '',
            'parent_id'=>108,
            'status'=>2
        ]);

        //ID:172 保单审核
        factory(\App\Models\Menu::class)->create([
            'name'=>'审核保单',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/order/audit',
            'description' => '审核保单',
            'parent_id'=>106,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:173 台账审核
        factory(\App\Models\Menu::class)->create([
            'name'=>'审核台账',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/pay/audit',
            'description' => '审核台账',
            'parent_id'=>113,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:174 佣金发放
        factory(\App\Models\Menu::class)->create([
            'name'=>'佣金发放',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/bill/audit',
            'description' => '佣金发放',
            'parent_id'=>120,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:175
        factory(\App\Models\Menu::class)->create([
            'name'=>'保单分页',
            'icons'=>'fa-list',
            'url'=>'/home/order/list',
            'description' => '保单分页数据',
            'parent_id'=>127,
            'status'=>2
        ]);

        //ID:176
        factory(\App\Models\Menu::class)->create([
            'name'=>'查看保单',
            'icons'=>'fa-edit',
            'url'=>'/home/order/edit',
            'description' => '保单详细页面',
            'parent_id'=>127,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:177 保险明细
        factory(\App\Models\Menu::class)->create([
            'name'=>'保险明细',
            'icons'=>'fa-outdent',
            'url'=>'/home/order-product/index',
            'description' => '',
            'parent_id'=>3,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:178
        factory(\App\Models\Menu::class)->create([
            'name'=>'保险明细分页',
            'icons'=>'fa-list',
            'url'=>'/home/order-product/list',
            'description' => '保险明细分页数据',
            'parent_id'=>177,
            'status'=>2
        ]);

        //ID:179
        factory(\App\Models\Menu::class)->create([
            'name'=>'查看保险明细',
            'icons'=>'fa-edit',
            'url'=>'/home/order-product/edit',
            'description' => '保险明细页面',
            'parent_id'=>177,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:180
        factory(\App\Models\Menu::class)->create([
            'name'=>'台账分页',
            'icons'=>'fa-list',
            'url'=>'/home/pay/list',
            'description' => '台账分页数据',
            'parent_id'=>128,
            'status'=>2
        ]);

        //ID:181
        factory(\App\Models\Menu::class)->create([
            'name'=>'查看台账',
            'icons'=>'fa-edit',
            'url'=>'/home/pay/edit',
            'description' => '台账详细页面',
            'parent_id'=>128,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:182
        factory(\App\Models\Menu::class)->create([
            'name'=>'佣金分页',
            'icons'=>'fa-list',
            'url'=>'/home/bill/list',
            'description' => '佣金分页数据',
            'parent_id'=>129,
            'status'=>2
        ]);

        //ID:183
        factory(\App\Models\Menu::class)->create([
            'name'=>'查看佣金',
            'icons'=>'fa-edit',
            'url'=>'/home/bill/edit',
            'description' => '佣金详细页面',
            'parent_id'=>129,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:184
        factory(\App\Models\Menu::class)->create([
            'name'=>'我的团队分页',
            'icons'=>'fa-list',
            'url'=>'/home/member/list',
            'description' => '我的团队分页数据',
            'parent_id'=>130,
            'status'=>2
        ]);

        //ID:185
        factory(\App\Models\Menu::class)->create([
            'name'=>'查看我的团队',
            'icons'=>'fa-edit',
            'url'=>'/home/member/edit',
            'description' => '我的团队详细页面',
            'parent_id'=>130,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:186 批量台账审核
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量审核台账',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/pay/batch-audit',
            'description' => '批量审核台账',
            'parent_id'=>113,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:187 批量台账带条件审核
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量条件审核台账',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/pay/condition-audit',
            'description' => '批量条件审核台账',
            'parent_id'=>113,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:188 佣金发放
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量佣金发放',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/bill/batch-audit',
            'description' => '批量佣金发放',
            'parent_id'=>120,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:189 佣金带条件发放
        factory(\App\Models\Menu::class)->create([
            'name'=>'批量佣金发放',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/bill/condition-audit',
            'description' => '批量佣金发放',
            'parent_id'=>120,
            'method'=>'2',
            'status'=>2
        ]);

        //ID:190 修改代理人工号
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改代理人工号',
            'icons'=>'fa-trash-o',
            'url'=>'/admin/member/update-uname',
            'description' => '修改代理人工号',
            'parent_id'=>55,
            'method'=>3,
            'status'=>2
        ]);

        //ID:191 导出代理人结佣架构
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出代理人结佣架构',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/member/export-organization',
            'description' => '导出代理人结佣架构',
            'parent_id'=>55,
            'method'=>1,
            'status'=>2
        ]);

        //ID:192 代理人工资账单
        factory(\App\Models\Menu::class)->create([
            'name'=>'工资账单',
            'icons'=>'fa-coffee',
            'url'=>'/admin/member/bill',
            'description' => '代理人工资账单',
            'parent_id'=>52,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:193
        factory(\App\Models\Menu::class)->create([
            'name'=>'工资账单分页',
            'icons'=>'fa-list',
            'url'=>'/home/member/bill-list',
            'description' => '工资账单分页数据',
            'parent_id'=>193,
            'status'=>2
        ]);

        //ID:194 导出代理人工资账单
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出工资账单',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/member/export-bill',
            'description' => '导出代理人工资账单',
            'parent_id'=>193,
            'status'=>2
        ]);

        //ID:195
        factory(\App\Models\Menu::class)->create([
            'name'=>'工资账单',
            'icons'=>'fa-coffee',
            'url'=>'/home/bill/month',
            'description' => '',
            'parent_id'=>40,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:196
        factory(\App\Models\Menu::class)->create([
            'name'=>'工资账单分页',
            'icons'=>'fa-list',
            'url'=>'/home/bill/month-list',
            'description' => '工资账单分页数据',
            'parent_id'=>195,
            'status'=>2
        ]);

        //ID:197
        factory(\App\Models\Menu::class)->create([
            'name'=>'导出佣金对账单',
            'icons'=>'fa-file-excel-o',
            'url'=>'/admin/pay/check-list',
            'description' => '导出佣金对账单',
            'parent_id'=>120,
            'status'=>2
        ]);

        //ID:198
        factory(\App\Models\Menu::class)->create([
            'name'=>'转换成佣金率表',
            'icons'=>'fa-registered',
            'url'=>'/admin/tolead/convert-to-pay',
            'description' => '',
            'method'=>'2',
            'parent_id'=>103,
            'status'=>2
        ]);

        //ID:199 搜索代理人
        factory(\App\Models\Menu::class)->create([
            'name'=>'代理人查询',
            'icons'=>'fa-cubes',
            'url'=>'/admin/member/search',
            'description' => '',
            'parent_id'=>108,
            'status'=>2
        ]);

        //ID:200 查询产品信息
        factory(\App\Models\Menu::class)->create([
            'name'=>'查询产品信息',
            'icons'=>'fa-cubes',
            'url'=>'/admin/product/one-years-and-pmodel',
            'description' => '',
            'parent_id'=>108,
            'status'=>2
        ]);

        //ID:201 代理人搜索
        factory(\App\Models\Menu::class)->create([
            'name'=>'查询推荐人列表',
            'icons'=>'fa-cubes',
            'url'=>'/admin/member/optional-parent',
            'description' => '',
            'parent_id'=>55,
            'status'=>2
        ]);

        //ID:202
        factory(\App\Models\Menu::class)->create([
            'name'=>'查询推荐人团队ID',
            'icons'=>'fa-cubes',
            'url'=>'/admin/member/one',
            'description' => '',
            'parent_id'=>55,
            'status'=>2
        ]);

        //ID:203
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端代理人导出',
            'icons'=>'fa-file-excel-o',
            'url'=>'/home/member/export',
            'description' => '前端代理人导出',
            'parent_id'=>130,
            'status'=>2
        ]);


        //重新排序整理菜单
        \App\Models\Menu::find(52)->moveNear(5,'after');
        \App\Models\Menu::find(105)->moveNear(52,'after');
        \App\Models\Menu::find(67)->moveNear(105,'after');
        \App\Models\Menu::find(15)->moveNear(8,'before');
        \App\Models\Menu::find(44)->moveNear(15,'before');
        \App\Models\Menu::find(164)->moveNear(106,'after');
        \App\Models\Menu::find(82)->moveNear(68,'before');
        \App\Models\Menu::find(177)->moveNear(127,'after');
        \App\Models\Menu::find(130)->moveNear(39,'after');
        \App\Models\Menu::find(40)->moveNear(129,'after');
        \App\Models\Menu::find(195)->moveNear(41,'before');


    }




}
