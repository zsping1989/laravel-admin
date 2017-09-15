<?php
/**
 * 配置模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Resource\Models\BaseModel;

class Config extends Model
{
    protected $table = 'configs'; //数据表名称
    use SoftDeletes,BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['name','description','key','value'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];

}
