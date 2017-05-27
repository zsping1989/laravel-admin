<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{

    protected $bindModel='App\Models\Role';

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
        DB::connection($connection)->statement("CREATE TABLE `".$prefix.$model->getTable()."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称@required',
  `description` text COLLATE utf8_unicode_ci COMMENT '描述\$textarea',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID@sometimes|required|exists:roles,id',
  `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
  `left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
  `right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色'");
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
