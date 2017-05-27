<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Role';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"name":"\u8d85\u7ea7\u7ba1\u7406\u5458","description":"\u62e5\u6709\u6240\u6709\u64cd\u4f5c\u6743\u9650","parent_id":0,"level":1,"left_margin":1,"right_margin":6,"created_at":"2017-04-21 11:06:32","updated_at":"2017-04-21 11:06:32","deleted_at":null},{"id":2,"name":"\u56e2\u961f\u7ba1\u7406\u5458","description":"\u56e2\u961f\u957f","parent_id":1,"level":2,"left_margin":2,"right_margin":3,"created_at":"2017-04-21 11:06:32","updated_at":"2017-04-21 11:06:32","deleted_at":null},{"id":3,"name":"\u8fd0\u8425\u7ba1\u7406\u5458","description":"\u8fd0\u8425\u7ba1\u7406\u5458","parent_id":1,"level":2,"left_margin":4,"right_margin":5,"created_at":"2017-04-25 10:57:08","updated_at":"2017-04-25 10:57:08","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
