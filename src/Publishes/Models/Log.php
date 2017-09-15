<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    use BaseModel,SoftDeletes; //基础模型

    protected $table = 'logs'; //数据表名称
    //批量赋值白名单
    protected $fillable = ['menu_id','user_id','location','ip','parameters','return'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];

    /**
     * 日志用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }


    /**
     * 日志对应菜单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }


}
