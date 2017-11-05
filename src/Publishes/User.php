<?php

namespace App;

use App\Models\Notification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Resource\Models\BaseModel;

class User extends Authenticatable
{
    use Notifiable,BaseModel,SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uname','password','name',
        'email','mobile_phone','qq','status','description'
    ];

    protected $dates = ['created_at','updated_at','deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
        //'uname','email'
    ];

    /**
     * 字段值map
     * @var array
     */
    protected $fieldsShowMaps = [
        'status'=>[
            '注销','有效','停用'
        ]
    ];

    /**
     * 字段默认值
     * @var array
     */
    protected $fieldsDefault = [
        'uname'=>'',
        'password'=>'',
        'name'=>'',
        'email'=>'',
        'mobile_phone'=>'',
        'qq'=>null,
        'remember_token'=>null,
        'status'=>2,
        'description'=>null
    ];

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    /**
     * 用户-后台用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }

    /**
     * 用户操作日志
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
         return $this->hasMany('App\Models\Log');
    }

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * 三方登录用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ousers(){
        return $this->hasMany('App\Models\Ouser');
    }



}
