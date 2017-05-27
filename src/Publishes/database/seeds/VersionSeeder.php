<?php

include_once base_path('database/seeds/OrderTableSeeder.php');
include_once base_path('database/seeds/BillTableSeeder.php');
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call('MenuTableSeeder');
        $this->call('ConfigTableSeeder');
        $this->call('OrderToPayTableSeeder');
        //DB::table('bills')->truncate();
        //$this->call('ConfigTableSeeder');
       /* DB::table('bills')->truncate();
        DB::table('orders')->truncate();
        DB::table('pays')->truncate();
        $this->call('BillTableSeeder');
        $this->call('OrderTableSeeder');
        $this->call('PayTableSeeder');*/

/*
        $this->call('MenuTableSeeder'); //菜单添加
        $this->call('MemberIdentityCardTableSeeder');

        DB::table('years')->truncate();
        $this->call('YearTableSeeder');
        DB::table('orders')->truncate();
        $this->call('OrderTableSeeder');
        DB::table('pays')->truncate();
        $this->call('PayTableSeeder');
        DB::table('classify_firm')->truncate();
        DB::table('classifys')->truncate();
        DB::table('firms')->truncate();
        DB::table('product_year')->truncate();
        DB::table('products')->truncate();
        DB::table('rates')->truncate();
        $this->call('FirmTableSeeder');
        $this->call('ClassifyTableSeeder');
        $this->call('ClassifyFirmTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('RateTableSeeder');
        $this->call('ProductYearTableSeeder');
        //批量授权管理员
        $this->createTeamLeader();*/


    }

 /*   public function createTeamLeader()
    {
        $team_leader = \App\Models\Role::find(2);
        \App\User::whereHas('member.grade', function ($q) {
            $q->where('value', '>=', 2); //等级值大于2的用户
        })->get()
            ->map(function ($item) use ($team_leader) {
                if (!$item->admin) { //添加后台管理员
                    $item->admin()//访问关联
                    ->save(factory(\App\Models\Admin::class)->make())//创建关联后台用户
                    ->roles()
                        ->save($team_leader); //分配团队长
                } else {
                    if (!$item->admin->roles->contains('id', 2)) {
                        $item->admin->roles()->save($team_leader); //分配团队长
                    }
                }
            });
    }*/
}
