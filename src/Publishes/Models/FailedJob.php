<?php
/**
 * 模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{

    use BaseModel; //基础模型
    //数据表名称
    protected $table = 'failed_jobs';
    //无需更新时间字段
    public $timestamps = false;
    //批量赋值白名单
    protected $fillable = ['connection','queue','payload','exception','failed_at'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = ['failed_at' => 'CURRENT_TIMESTAMP'];



}
