<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Team;
use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    use ResourceController;

    //默认排序
    protected $orderDefault = [
        'updated_at' => 'desc',
        'id'=>'asc'
    ];
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Role';

    protected $sizer = [
        'name' => 'like'
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'id', 'name', 'description', 'parent_id', 'level',
        'created_at', 'updated_at',
        'parent' => ['name', 'id']
    ];

    /**
     * Index页面字段名称显示多条数据统计值
     * @var array
     */
    public $showIndexFieldsCount=['admins'];

    /**
     * 编辑页面时的字段值
     * @var array
     */
    public $editFields = [
        'menus'=>['id']
    ];

    /**
     * 编辑页面
     */
    public function edit($id = null)
    {
        $data['row'] = collect($this->getOne($id))->toArray();
        //数据字段映射信息
        $data['maps'] = $this->bindModel()->getFieldsMap();
        //查询可选择的父级角色
        $data['maps']['optional_parents'] = Role::optionalParent($id ? $data['row'] : null)
            ->orderBy('left_margin', 'asc')
            ->get();
        //查询当前用户拥有后台权限
        $home_menu = Menu::find(3);
        $menus_id = collect(array_get($data,'row.menus',[]))->pluck('id')->toArray();
        //可选权限
        $data['maps']['permissions'] = collect(app('user.logic')->getUserInfo('menus'))
            ->filter(function($item)use($home_menu){
                return !($item['left_margin']>=$home_menu['left_margin'] && $item['right_margin']<=$home_menu['right_margin']);
            })->values()->map(function($item)use($menus_id){
                unset($item['url']);
                $item['checked'] = in_array($item['id'],$menus_id);
                return $item;
            });
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl('edit');
        //$data['configUrl']['indexUrl'] = '';
        return Response::returns($data); //获取一条记录
    }
    /**
     *
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all=false){
        return app('user.logic')->getAdminRolesAndChilds($all)->pluck('id')->toArray();
    }

    /**
     * 执行修改或添加
     */
    public function postEdit(\Illuminate\Http\Request $request)
    {
        $this->validate($request, $this->getValidateRule());//验证数据
        $id = $request->get('id');
        $this->bindModel OR $this->bindModel(); //绑定模型
        if($id && !app('user.logic')->getUserInfo('isSuperAdmin') && !in_array($id,$this->rolesChildsId())){
            return ['alert'=>alert(['message'=>'你无权修改该角色!'],422)];
        }
        //添加或修改角色父ID权限判断
        if(!app('user.logic')->getUserInfo('isSuperAdmin')){
            $parent_id = $request->get('parent_id');
            if(!$parent_id || !in_array($parent_id,$this->rolesChildsId(true))){
                return ['alert'=>alert(['message'=>'设置父级角色只能是你有权限的角色分组!'],422)];
            }
        }
        //当前用户拥有的权限
        $have = collect(app('user.logic')->getUserInfo('menus'))->pluck('id')->all();
        //新角色权限
        $new_permissions = collect($request->get('menus'))->pluck('id')->intersect($have)->all();

        $data = $id ? $request->all() : $request->except('id');
        if ($id) {
            $role = $this->bindModel->find($id);
            $res = $role->update($data);
            if ($res === false) {
                return Response::returns(['alert' => alert(['message' => '修改失败!'], 500)]);
            }
            //修改菜单-角色关系
            if($id!=1){
                //当前用户拥有该角色的旧权限
                $old_permissions = $role->menus->pluck('id')
                    ->intersect($have)
                    ->all();
                //删除旧的权限,添加新权限
                $add_permissions = collect($new_permissions)->diff($old_permissions)->all();
                $del_permissions = collect($old_permissions)->diff($new_permissions)->all();
                //新增权限父节点都将拥有
                Role::parents($role,true)->get()->each(function($item) use($add_permissions,$del_permissions){
                    $del_permissions AND $item->menus()->detach($del_permissions);
                    $add_permissions AND MenuRole::insertReplaceAll(collect($add_permissions)->map(function($value)use($item){
                        return ['role_id'=>$item['id'],'menu_id'=>$value];
                    })->toArray());
                });
                //删除节点权限子节点都删除
                Role::children($role)->get()->each(function($item) use($del_permissions){
                    $del_permissions AND $item->menus()->detach($del_permissions);
                });
            }
            //更新用户信息
            app('user.logic')->loginCacheInfo();
            return Response::returns(['alert' => alert(['message' => '修改成功!'])]);
        }

        //新增
        $res = $this->bindModel->create($data);
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '新增失败!'], 500)]);
        }
        //所有父节点添加对应权限
        Role::parents($res,true)->each(function($item)use($new_permissions){
            $new_permissions AND MenuRole::insertReplaceAll(collect($new_permissions)->map(function($value)use($item){
                return ['role_id'=>$item['id'],'menu_id'=>$value];
            })->toArray());
        });
        //更新用户信息
        app('user.logic')->loginCacheInfo();
        return Response::returns(['alert' => alert(['message' => '新增成功!'])]);
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return [
            'name' => 'required',
            'parent_id' => 'sometimes|required|exists:roles,id'
        ];
    }


}
