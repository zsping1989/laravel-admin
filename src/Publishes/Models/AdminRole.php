<?php
/**
 * 后台用户-角色关联模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use BaseModel;

    protected $table = 'admin_role'; //数据表名称

    public $timestamps = false;
    //批量赋值白名单
    protected $fillable = ['admin_id','role_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
