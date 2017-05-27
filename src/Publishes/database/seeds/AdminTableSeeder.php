<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Admin';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"user_id":1,"created_at":"2017-04-10 03:36:00","updated_at":"2017-04-10 03:36:00","deleted_at":null},{"id":2,"user_id":422,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":3,"user_id":539,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":4,"user_id":796,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":5,"user_id":135,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":6,"user_id":36,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":7,"user_id":249,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":8,"user_id":383,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":9,"user_id":432,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":10,"user_id":655,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":11,"user_id":360,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":12,"user_id":21,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":13,"user_id":299,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":14,"user_id":671,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":15,"user_id":706,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":16,"user_id":113,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":17,"user_id":440,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":18,"user_id":783,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":19,"user_id":196,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":20,"user_id":6,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":21,"user_id":42,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":22,"user_id":153,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":23,"user_id":15,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":24,"user_id":8,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":25,"user_id":79,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":26,"user_id":11,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":27,"user_id":26,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":28,"user_id":84,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":29,"user_id":836,"created_at":"2017-04-10 07:43:22","updated_at":"2017-04-10 07:43:22","deleted_at":null},{"id":30,"user_id":30,"created_at":"2017-04-24 07:42:22","updated_at":"2017-04-24 07:42:22","deleted_at":null},{"id":31,"user_id":1031,"created_at":"2017-04-24 07:48:02","updated_at":"2017-04-24 07:48:02","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
