<?php
/**
 * 三方用户模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ouser extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ousers';
    //批量赋值白名单
    protected $fillable = ['user_id','type','open_id','data'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = ['type'=>["1"=>'qq',"2"=>'weixin',"3"=>'weibo']];
    //字段默认值
    protected $fieldsDefault = ['user_id' => 0,'type' => 0,'open_id' => ''];


    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getDataAttribute($value)
    {
        return json_decode($value,true);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
