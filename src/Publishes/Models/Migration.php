<?php
/**
 * 模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Migration extends Model
{
    protected $table = 'migrations'; //数据表名称
    use SoftDeletes,BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['id','migration','batch'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
