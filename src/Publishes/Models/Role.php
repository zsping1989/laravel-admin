<?php
/**
 * 角色模型
 */
namespace App\Models;
use MarginTree\ExcludeTop;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use TreeModel; //树状结构
    use SoftDeletes,BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['name','description','parent_id'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    /**
     * 字段值map
     * @var array
     */
    public $fieldsShowMaps = [
    ];


    /* 角色-权限菜单 */
    public function menus(){
        return $this->belongsToMany('App\Models\Menu');
    }

    /* 角色-用户 */
    public function admins(){
        return $this->belongsToMany('App\Models\Admin','admin_role','role_id','admin_id');
    }



}
