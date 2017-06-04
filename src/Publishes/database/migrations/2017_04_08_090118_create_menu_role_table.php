<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMenuRoleTable extends Migration
{

    protected $bindModel='App\Models\MenuRole';

    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement("CREATE TABLE IF NOT EXISTS `".$prefix.$model->getTable()."` (
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID',
  PRIMARY KEY (`role_id`,`menu_id`),
  KEY `menu_role_role_id_index` (`role_id`),
  KEY `menu_role_menu_id_index` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='菜单-角色关联'");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $model = new $this->bindModel();
        $prefix = $model->getConnection()->getTablePrefix();
        $connection = $model->getConnectionName()?: config('database.default');
        DB::connection($connection)->statement('drop table `'.$prefix.$model->getTable().'`;');
    }
}
