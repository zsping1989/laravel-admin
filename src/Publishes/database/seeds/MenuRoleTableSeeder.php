<?php

use Illuminate\Database\Seeder;

class MenuRoleTableSeeder extends Seeder
{
    protected $bindModel='App\Models\MenuRole';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"role_id":1,"menu_id":3},{"role_id":1,"menu_id":13},{"role_id":1,"menu_id":14},{"role_id":1,"menu_id":15},{"role_id":1,"menu_id":16},{"role_id":1,"menu_id":17},{"role_id":1,"menu_id":19},{"role_id":1,"menu_id":20},{"role_id":1,"menu_id":21},{"role_id":1,"menu_id":22},{"role_id":1,"menu_id":23},{"role_id":1,"menu_id":24},{"role_id":1,"menu_id":25},{"role_id":1,"menu_id":26},{"role_id":1,"menu_id":30},{"role_id":1,"menu_id":31},{"role_id":1,"menu_id":38},{"role_id":1,"menu_id":39},{"role_id":1,"menu_id":41},{"role_id":1,"menu_id":42},{"role_id":1,"menu_id":47},{"role_id":1,"menu_id":48},{"role_id":1,"menu_id":50},{"role_id":1,"menu_id":51},{"role_id":1,"menu_id":53},{"role_id":1,"menu_id":54},{"role_id":1,"menu_id":56},{"role_id":1,"menu_id":57},{"role_id":1,"menu_id":59},{"role_id":1,"menu_id":60},{"role_id":1,"menu_id":62},{"role_id":1,"menu_id":63},{"role_id":1,"menu_id":65},{"role_id":1,"menu_id":66},{"role_id":2,"menu_id":3},{"role_id":2,"menu_id":13},{"role_id":3,"menu_id":3},{"role_id":3,"menu_id":13},{"role_id":3,"menu_id":14},{"role_id":3,"menu_id":15},{"role_id":3,"menu_id":16},{"role_id":3,"menu_id":17},{"role_id":3,"menu_id":19},{"role_id":3,"menu_id":20},{"role_id":3,"menu_id":21},{"role_id":3,"menu_id":22},{"role_id":3,"menu_id":23},{"role_id":3,"menu_id":24},{"role_id":3,"menu_id":25},{"role_id":3,"menu_id":26},{"role_id":3,"menu_id":30},{"role_id":3,"menu_id":31},{"role_id":3,"menu_id":38},{"role_id":3,"menu_id":39},{"role_id":3,"menu_id":41},{"role_id":3,"menu_id":42},{"role_id":3,"menu_id":47},{"role_id":3,"menu_id":48},{"role_id":3,"menu_id":50},{"role_id":3,"menu_id":51},{"role_id":3,"menu_id":53},{"role_id":3,"menu_id":54},{"role_id":3,"menu_id":56},{"role_id":3,"menu_id":57},{"role_id":3,"menu_id":59},{"role_id":3,"menu_id":60},{"role_id":3,"menu_id":62},{"role_id":3,"menu_id":63},{"role_id":3,"menu_id":65},{"role_id":3,"menu_id":66}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
