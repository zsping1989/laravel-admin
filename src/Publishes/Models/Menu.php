<?php
/**
 * 菜单模型
 */
namespace App\Models;
use Resource\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use MarginTree\ExcludeTop;
use MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    protected $table = 'menus'; //数据表名称
    //软删除,树状结构
    use SoftDeletes,TreeModel,ExcludeTop;


    //批量赋值白名单
    protected $fillable = ['id','name','icons','description','url','parent_id','method','is_page','status'];
    //输出隐藏字段

    /* 菜单-角色 */
    public function roles(){
       return $this->belongsToMany('App\Models\Role');
    }
}
