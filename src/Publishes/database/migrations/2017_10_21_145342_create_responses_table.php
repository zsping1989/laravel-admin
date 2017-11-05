<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateResponsesTable extends Migration
{

    protected $bindModel='App\Models\Response';

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
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '接口ID@required|exists:menus,id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '结果字段@required|alpha_dash',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述\$textarea',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `api_responses_menu_id_index` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='接口响应\$softDeletes,timestamps@belongsTo:memu'");
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
