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

        //用于计算税后佣金
        factory(\App\Models\Config::class)->create([
            'key'=>'tax_rate',
            'name'=>'税率(谨慎操作!)',
            'description'=>'用于计算税后佣金',
            'value'=>'0.9'
        ]);

        //默认工号前缀
        factory(\App\Models\Config::class)->create([
            'key'=>'job_number_prefix',
            'name'=>'团队工号默认前缀',
            'description'=>'团队工号前缀没填写时的默认值',
            'value'=>'B001'
        ]);

        //后勤团队工号前缀
        factory(\App\Models\Config::class)->create([
            'key'=>'serve_team_prefix',
            'name'=>'后勤团队工号前缀',
            'description'=>'后勤团队工号前缀',
            'value'=>'IOPS'
        ]);

        //创建用户默认密码
        factory(\App\Models\Config::class)->create([
            'key'=>'default_password',
            'name'=>'默认密码配置',
            'description'=>'当用户没有身份证号码等任何信息时的默认密码',
            'value'=>'xdy123'
        ]);

        //最多基础佣金个数
        factory(\App\Models\Config::class)->create([
            'key'=>'rates_count',
            'name'=>'基础佣金个数限制',
            'description'=>'最多可添加基础佣金个数',
            'value'=>'5'
        ]);

        //最小推荐奖系数
        factory(\App\Models\Config::class)->create([
            'key'=>'recommended_award_rate',
            'name'=>'最小推荐系数(谨慎操作!)',
            'description'=>'当下级推荐一个高职级人员的直接推荐奖系数值,用于推荐奖计算',
            'value'=>'0.1'
        ]);


        //短期险种分类
        factory(\App\Models\Config::class)->create([
            'key'=>'short_term_classifys',
            'name'=>'短期险种分类(谨慎操作!)',
            'description'=>'填写属于短期险种的分类用","分隔,用于佣金结算谨慎操作',
            'value'=>'一年期业务,短期健康险'
        ]);

        //高级职级界定
        factory(\App\Models\Config::class)->create([
            'key'=>'advanced_rank',
            'name'=>'高级职级系数界定(谨慎操作!)',
            'description'=>'机构合伙人以上的系数',
            'value'=>'2'
        ]);

        //最高职级系数
        factory(\App\Models\Config::class)->create([
            'key'=>'top_rank',
            'name'=>'最高职级系数(谨慎操作!)',
            'description'=>'顶级系数',
            'value'=>'2.3'
        ]);

        //禁止登陆用户团队ID
        factory(\App\Models\Config::class)->create([
            'key'=>'landed_team',
            'name'=>'禁止团队登陆',
            'description'=>'禁止登陆用户团队ID',
            'value'=>json_encode([])
        ]);

        //签单日期计算所属月份开关
        factory(\App\Models\Config::class)->create([
            'key'=>'calculate_month_by_sign_at',
            'name'=>'签单日期计算业务所属月份开关',
            'description'=>'用于结算账单属于某月',
            'value'=>1
        ]);

        //回执计算所属月份开关
        factory(\App\Models\Config::class)->create([
            'key'=>'calculate_month_by_end_at',
            'name'=>'交回执日期计算业务所属月份开关',
            'description'=>'用于结算账单属于某月',
            'value'=>1
        ]);

        //回执计算所属月份开关
        factory(\App\Models\Config::class)->create([
            'key'=>'max_periods',
            'name'=>'最远生成期数(单位:年)',
            'description'=>'生成远的台账数量',
            'value'=>5
        ]);

    }
}
