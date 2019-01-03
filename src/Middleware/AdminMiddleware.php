<?php

namespace LaravelAdmin\Middleware;

use App\Models\Log;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Resource\Facades\Data;
use LaravelAdmin\Facades\MenuLogic;

class AdminMiddleware{
    /**
     * 操作日志ID
     * @var
     */
    protected static $log_id=0;
    /**
     * 脚本运行时调用
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $url = Route::getCurrentRoute()->getCompiled()->getStaticPrefix();
        //记录用户操作日志
        if(!in_array($url,
            ['/admin/log/edit','/admin/log/index','/admin/log/list','/admin/log/export'])
        && ends_with($url,'edit')
        ){ //排除无需日志记录
            $log = Log::create([
                'menu_id'=>array_get(Menu::getNowMenu(),'id',0),
                'user_id'=>array_get(Auth::user(),'id'),
                'location'=>collect(app('ip2city')->ip2addr(app('request')->getClientIp()))
                    ->unique()
                    ->filter()
                    ->implode(','),
                'ip'=>app('request')->getClientIp() ,
                'parameters'=>json_encode(Request::all(),JSON_UNESCAPED_UNICODE),
                'return'=>''
            ]);
            self::$log_id = $log['id'];
        }
        //不是管理员,跳转到前台首页
        if(!User::isAdmin()){
            if(canRedirect() || app('request')->has('define')){
                return orRedirect('/admin/index/page404');
            }
            return Response::returns(['alert'=>alert(['message'=>'你还不是后台管理员,请联系管理员!'],404)],404);
        }

        //不是超级管理员,需要验证权限
        if(!Role::isSuper()){
            //当前用户拥有的菜单权限
            $menus =  Menu::getMain();

            //当前路由
            $route = Route::getCurrentRoute()->getCompiled()->getStaticPrefix();
            //请求方式
            $method = array_get(array_flip(Menu::getFieldsMap('method')->toArray()),strtolower(app('request')->method()),0);

            //判断当前路由是否在拥有权限url中
            $hasPermission = Menu::isUrlInMenus($route,$menus,$method);

            //没有权限
            if(!$hasPermission){
                if(canRedirect() || app('request')->has('define')){
                    return orRedirect('/admin/index/page404');
                }
                return Response::returns(['alert'=>alert(['message'=>'你没有访问权限,请联系管理员!'],404)],404);
            }
        }
        $response = $next($request);
        //后置操作
        return $response;
    }


    /**
     *
     * 结果返回到客户端后调用
     *
     * Handle an incoming request.
     *
     * param  \Illuminate\Http\Request  $request
     * param  \Closure  $next
     * return mixed
     */
    public function terminate($request, $response)
    {
        if(self::$log_id){
            //写入返回数据
            Log::where('id',self::$log_id)->update(['return'=>str_limit(json_encode(Data::all(),JSON_UNESCAPED_UNICODE),60000)]);
        }
    }
}
