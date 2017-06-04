<?php
/**
 * 重置密码模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{
    protected $table = 'password_resets'; //数据表名称
    use BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['email','token'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at'];

}
