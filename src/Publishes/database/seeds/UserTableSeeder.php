<?php

use Illuminate\Database\Seeder;

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
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"uname":"admin","password":"$2y$10$L7t3MwkQjX6Arcv4wGYJ3udmvPPzyAeu99KB8Rzz9OMYU3drTDKbi","name":"\u7cfb\u7edf","email":"214986304@qq.com","mobile_phone":"13699411148","qq":214986304,"remember_token":"qH1Y04gXKEcZ4kq59Rrxim2UbAQCui2PL4A5ifiEVPtHS66t40VYj0scpxi1","status":1,"description":null,"created_at":"2017-04-09 09:22:03","updated_at":"2017-04-09 09:22:03","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
