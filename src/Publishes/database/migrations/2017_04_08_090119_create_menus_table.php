<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMenusTable extends Migration
{

    protected $bindModel='App\Models\Menu';

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称@required',
  `icons` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图标@alpha_dash',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述\$textarea',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'URL路径',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID@sometimes|required|exists:menus,id',
  `method` int(11) NOT NULL DEFAULT '1' COMMENT '请求方式:1-get,2-post,3-put\$radio@in:1,2,3',
  `is_page` int(11) NOT NULL DEFAULT '0' COMMENT '是否为页面:0-否,1-是\$radio@in:0,1',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态:1-显示,2-不显示\$radio@in:1,2',
  `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
  `left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
  `right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='菜单'");
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
