<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:14
 */
namespace LaravelAdmin\Logics;

use App\Models\Menu;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserLogic{
    //存储后台用户信息
    protected $admin;
    //用户信息
    protected $user;

    public function __construct()
    {
        $this->user = $this->getUser();
        $this->admin = $this->user ? $this->user->admin : null;
    }

    /**
     * 获取登录用户
     * 返回: mixed
     */
    public function getUser(){
       return Auth::user();
    }

    /**
     * 获取用户真实信息
     */
    public function getMember(){
        return $this->getUser()->member;
    }

    /**
     * 后台权限白名单(菜单ID)
     * 返回: array
     */
    public function getMenuWhiteListIds(){
        return $this->getHomeMenus()->pluck('id')->merge([])->toArray();
    }

    /**
     * 前端模块菜单
     */
    public function getHomeMenus(){
        $home = Menu::find(2);
        return Menu::whereRaw('left_margin>='.$home['left_margin'].' AND right_margin<='.$home['right_margin'])
            ->orderBy('left_margin')->get();
    }


    /**
     * 获取当前用户的后台角色信息
     * 返回: mixed
     */
    public function getAdmin(){
        return $this->admin;
    }


    /**
     * 判断当前登录用户是否是后台管理员
     * 返回: bool
     */
    public function isAdmin(){
        return !!$this->admin;
    }

    /**
     * 判断当前用户是否是管理员
     * 返回: mixed
     */
    public function isSuperAdmin(){
        return $this->admin->roles->contains('id',1);
    }

    /**
     * 判断当前用户是否拥有某权限
     * @param $url
     * @return bool
     */
    public function hasPermission ($url){
        return collect($this->getUserInfo('menus'))
            ->pluck('url')
            ->contains($url);
    }

    /**
     * 获取当前后台用户角色的所有角色及下属角色
     * 返回: mixed
     */
    public function getAdminRolesAndChilds($all=true){
        $roles = $this->admin->roles; //当前用户角色
        $roleModel = Role::whereRaw('false'); //角色模型
        $exp = $all ? '=':'';
        //查询所有包含自己及子节点
        foreach($roles as $role){
            $roleModel->orWhere(function($query) use($role,$exp){
                $query->where('left_margin', '>'.$exp, $role->left_margin)
                    ->where('right_margin', '<'.$exp,$role->right_margin);
            });
        }
        return $roleModel->orderBy('left_margin')->get();
    }

    /**
     * 获取当前后台用户拥有的后台菜单
     */
    public function getAdminMenus(){
        //是超级管理员
        if($this->isSuperAdmin()){
            $menus = Menu::orderBy('left_margin')->get();
        }else{
            //获取当前用户角色及下属角色ID
            $roles = $this->getAdminRolesAndChilds();
            //获取含有的权限url
            $obj = Menu::whereHas('roles',function ($q) use ($roles){
                $q->whereIn('id',$roles->pluck('id'));
            })->orWhereIn('id',$this->getMenuWhiteListIds())
                ->orderBy('left_margin');
            $menus = $obj->get();
        }
        return $menus;
    }

    /**
     * 缓存用户信息
     * @param $data
     * @param bool $key
     */
    public function putCacheUserInfo($data,$key=false){
        $userInfo  = session('userInfo') ?: [];
        if($key){
            $userInfo[$key] = $data;
        }else{
            foreach($data as $k=>$value){
                $userInfo[$k] = $value;
            }
        }
        return session()->put('userInfo',$userInfo);
    }

    /**
     * 登录成功缓存信息
     * 返回: mixed
     */
    public function loginCacheInfo(){
        $data = collect($this->user)->toArray();
        if($this->admin){
            $this->admin->roles;
            $data['admin'] = $this->admin->toArray(); //后台用户数据缓存
            $data['admin']['rolesAndChilds'] = $this->getAdminRolesAndChilds()->toArray(); //所有子级角色
            $data['menus'] = $this->getAdminMenus()->toArray(); //菜单数据,用于判断权限
            $data['isSuperAdmin'] =$this->isSuperAdmin(); //判断用户是否是超级管理员
        }else{
            $data['admin'] = null;
            $data['menus'] = $this->getHomeMenus()->toArray();
            $data['isSuperAdmin'] = false;
        }

        //导航数据
        $data['navigation'] = collect($data['menus'])->filter(function($item){
            return $item['status']==1;
        })->toArray();
        return $this->putCacheUserInfo($data);
    }


    /**
     * 获取用户缓存信息
     * param string $key
     * 返回: mixed
     */
    public function getUserInfo($key=''){
        $key and $key = '.'.$key;
        //session过期,重新缓存
       // if(!session('userInfo')){
            $this->loginCacheInfo();
        //}
        return session('userInfo'.$key);
    }


    /**
     * 检查用户是否可被当前用户编辑
     * param $user
     * 返回: bool
     */
    public function checkEditUser(User $user){
        $no_disabled = false;
        $admin = $user->admin;
        $admin and $admin->roles ;
        //判断该用户是否可被当前随便修改
        $main_roles = $this->getUserInfo('admin.rolesAndChilds'); //当前用户角色,数组
        //如果被编辑用户的角色在用户的
        foreach($main_roles as $main_role){
            $flog = true; //拥有编辑权限标记
            if(!isset($admin->roles)){
                $no_disabled = true;
                break;
            }
            foreach($admin->roles as $role){
                if(!($role->left_margin>$main_role['left_margin'] && $role->right_margin<$main_role['right_margin'])){
                    $flog = false;
                }
            }
            $flog AND $no_disabled = true;
        }
        return $no_disabled;
    }


    /**
     * 判断是否拥有子角色
     * @return bool
     */
    public function hasChildRole(){
        $roles = collect($this->getUserInfo('admin.rolesAndChilds'));
        if(!$roles->count()){
            return false;
        }
        $data_keys = $roles->pluck('id');
        $top = $roles->filter(function($item)use($data_keys){ //查询顶级节点
            return !$data_keys->contains($item['parent_id']);
        });
        return $top->count()!=$roles->count();
    }




}