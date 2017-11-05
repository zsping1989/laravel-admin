<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOusersTable extends Migration
{

    protected $bindModel='App\Models\Ouser';

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型:1-qq,2-weixin,3-weibo\$select',
  `open_id` varchar(255) NOT NULL DEFAULT '' COMMENT '用户唯一标识',
  `data` text NOT NULL COMMENT '用户信息',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `ousers_type_open_id_index` (`type`,`open_id`),
  KEY `ouser_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='三方用户\$softDeletes,timestamps@belongsTo:user'");
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
        DB::connection($connection)->statement('DROP TABLE IF EXISTS `'.$prefix.$model->getTable().'`;');
    }
}
