<?php
/**
 * 模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    use BaseModel; //基础模型
    //数据表名称
    protected $table = 'jobs';
    //无需更新时间字段
    public $timestamps = false;
    //批量赋值白名单
    protected $fillable = ['queue','payload','attempts','reserved_at','available_at'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [];



}
