<?php

use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
{
    protected $bindModel='App\Models\AdminRole';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"admin_id":1,"role_id":1},{"admin_id":2,"role_id":2},{"admin_id":3,"role_id":2},{"admin_id":4,"role_id":2},{"admin_id":5,"role_id":2},{"admin_id":6,"role_id":2},{"admin_id":7,"role_id":2},{"admin_id":8,"role_id":2},{"admin_id":9,"role_id":2},{"admin_id":10,"role_id":2},{"admin_id":11,"role_id":2},{"admin_id":12,"role_id":2},{"admin_id":13,"role_id":2},{"admin_id":14,"role_id":2},{"admin_id":15,"role_id":2},{"admin_id":16,"role_id":2},{"admin_id":17,"role_id":2},{"admin_id":18,"role_id":2},{"admin_id":19,"role_id":2},{"admin_id":20,"role_id":2},{"admin_id":21,"role_id":2},{"admin_id":22,"role_id":2},{"admin_id":23,"role_id":2},{"admin_id":24,"role_id":2},{"admin_id":25,"role_id":2},{"admin_id":26,"role_id":2},{"admin_id":27,"role_id":2},{"admin_id":28,"role_id":2},{"admin_id":29,"role_id":2},{"admin_id":30,"role_id":2},{"admin_id":31,"role_id":2}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
