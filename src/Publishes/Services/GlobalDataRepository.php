<?php

namespace App\Services;


use App\Models\Menu;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\Notification;
use App\Notifications\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use LaravelAdmin\Facades\UserLogic;
use Resource\Contracts\GlobalDataContract;
use Resource\Facades\Data;
use App\Notifications\Message;

class GlobalDataRepository implements GlobalDataContract{

    /**
     * 设置页面需要返回的公共数据
     */
    public function setPageData()
    {
        $global = [];
        $global['app_name'] = config('app.name');
        $global['app_name_initial'] = config('app.name_initial');
        $global['app_logo'] = config('app.logo');
        $global['token'] = csrf_token();
        $global['page'] = collect(explode('/',Route::getCurrentRoute()
            ->getCompiled()
            ->getStaticPrefix()))
            ->filter()
            ->values()
            ->forget(0)
            ->map(function($item){
                return str_replace('-','_',$item);
            })->implode('-');
        $global['page_path'] = str_replace('-','/',$global['page']);
        $route_key = md5(app('request')->getPathInfo()); //面包屑导航信息
        $navs = [];//Cache::get(config('cache-key.menu_navbar'),[]);
        $global['navs'] = array_get($navs,$route_key,function()use($navs,$route_key){
            $navs[$route_key] = app('menu.logic')->getNavbar();
            Cache::put(config('cache-key.menu_navbar'), $navs, 1440);
            return $navs[$route_key];
        });
        $navkeys = collect($global['navs'])->pluck('id');

        $main = UserLogic::getUser();
        $global['user'] = $main; //用户信息
        if(UserLogic::getUserInfo('admin')){ //是后台用户
            $global['user']['role_name'] = collect(UserLogic::getUserInfo('admin.roles'))
                ->pluck('name')
                ->implode('|')?:'后台管理员';
        }else if($main && $main->member){
            $global['user']['role_name'] = '代理人员';
        }else{
            $global['user']['role_name'] = '普通游客';
        }
        $menus = $main ? getUserInfo('navigation') : []; //菜单数据
        $menus = collect($menus)->map(function($item)use($navkeys){
            $item['active'] = $navkeys->contains($item['id']);
            $item['open'] = $item['active'];
            return $item;
        });
        $global['menus_module'] = $menus->where('level', 2); //模块菜单
        $global['menus'] = list_to_tree(collect($menus)->where('status', 1)->toArray(),'id','parent_id','childrens',array_get($navkeys,0));//菜单树状结构
        //最新消息
        $global['news'] = $main ? [
            'messages'=>$this->getNotifications(Message::class),
            'notifications'=>$this->getNotifications(Notification::class),
            'tasks'=>$this->getNotifications(Task::class)
        ] : ['messages'=>[],'notifications'=>[],'tasks'=>[]];
        $global['module'] = getModule();
        Data::set('global',$global);
    }

    protected function getNotifications($type){
        $data = UserLogic::getUser()->unreadNotifications()
            ->where('type','=',$type)
            ->paginate(5)
            ->toArray();
        $now = new Carbon();
        $data['data'] = collect($data['data'])->map(function($item)use($now){
            $item['diff_time'] = (new Carbon($item['created_at']))->diffForHumans($now);
            return $item;
        });
        return $data;
    }
}