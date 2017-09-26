<?php
/**
 * 菜单模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use MarginTree\ExcludeTop;
use MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Resource\Models\BaseModel;

class Menu extends Model
{
    protected $table = 'menus'; //数据表名称
    //软删除,树状结构
    use SoftDeletes,TreeModel,ExcludeTop,BaseModel;


    //批量赋值白名单
    protected $fillable = ['name','icons','description','url','parent_id','method','is_page','status'];
    //输出隐藏字段

    /**
     * 字段值map
     * @var array
     */
    protected $fieldsShowMaps = [
        'method'=>[
            1=>'get',
            2=>'post',
            4=>'put',
            8=>'delete',
            16=>'head',
            32=>'options',
            64=>'trace',
            128=>'connect'
        ],
        'is_page'=>['否','是'],
        'status'=>[1=>'显示',2=>'不显示']
    ];

    /**
     * 字段默认值
     * @var array
     */
    protected $fieldsDefault = [
        'name'=>'',
        'icons'=>'',
        'url'=>'',
        'description'=>'',
        'parent_id'=>0,
        'method'=>1,
        'is_page'=>0,
        'status'=>2,
        'level'=>0,
        'left_margin'=>0,
        'right_margin'=>0
    ];

    /**
     * 菜单-角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
       return $this->belongsToMany('App\Models\Role');
    }


    /**
     * 菜单-操作日志
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany('App\Models\Log');
    }

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getMethodAttribute($value)
    {
        $field = $this->getFieldsMap('method')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setMethodAttribute($value)
    {
        $this->attributes['method'] = multipleToNum($value);
    }

}
