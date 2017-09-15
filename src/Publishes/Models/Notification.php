<?php
/**
 * 地区模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Notification extends DatabaseNotification
{
    use BaseModel;

    protected $table = 'notifications'; //数据表名称
    //批量赋值白名单
    protected $fillable = ['type','notifiable_id','notifiable_type','data'];
    //日期字段
    protected $dates = ['created_at','updated_at','read_at'];

    /**
     * 字段值map
     * @var array
     */
    protected $fieldsShowMaps = [
        'type'=>[
            'App\Notifications\Message'=>'消息',
            'App\Notifications\Notification'=>'提醒',
            'App\Notifications\Task'=>'任务'
        ],
        'read_at'=>[
            0=>'已读',
            1=>'未读'
        ]
    ];

    /**
     *
     * @param  $value
     * @return  array
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value,JSON_UNESCAPED_UNICODE);
    }

}
