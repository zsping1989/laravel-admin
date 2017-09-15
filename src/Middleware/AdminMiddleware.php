<?php

namespace LaravelAdmin\Middleware;

use App\Models\Log;
use App\Models\Menu;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Resource\Facades\Data;
use LaravelAdmin\Facades\MenuLogic;

class AdminMiddleware{
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
        //不是管理员,跳转到前台首页
        if(!app('user.logic')->getUserInfo('admin')){
            if(canRedirect() || app('request')->has('define')){
                return orRedirect('/admin/index/page404');
            }
            return Response::returns(['alert'=>alert(['message'=>'你还不是后台管理员,请联系管理员!'],404)],404);
        }

        //不是超级管理员,需要验证权限
        if(!app('user.logic')->getUserInfo('isSuperAdmin')){
            //当前用户拥有的菜单权限
            $menus = app('user.logic')->getUserInfo('menus');

            //当前路由
            $route = Route::getCurrentRoute()->getCompiled()->getStaticPrefix();
            //请求方式
            $method = array_get(array_flip(Menu::getFieldsMap('method')->toArray()),strtolower(app('request')->method()),0);

            //判断当前路由是否在拥有权限url中
            $hasPermission = app('menu.logic')->isUrlInMenus($route,$menus,$method);

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
        //结果成功返回到客户端后执行,记录用户操作日志
        if(!in_array(Route::getCurrentRoute()->getCompiled()->getStaticPrefix(),
            ['/admin/log/edit','/admin/log/index','/admin/log/list','/admin/log/export'])){ //排除无需日志记录
            Log::create([
                'menu_id'=>array_get(MenuLogic::getNowMenu(),'id',0),
                'user_id'=>array_get(Auth::user(),'id'),
                'location'=>collect(app('ip2city')->ip2addr(app('request')->getClientIp()))
                    ->unique()->filter()->implode(','),
                'ip'=>app('request')->getClientIp() ,
                'parameters'=>json_encode(Request::all(),JSON_UNESCAPED_UNICODE),
                'return'=>str_limit(json_encode(Data::all(),JSON_UNESCAPED_UNICODE),60000) //防止数据过长
            ]);
        }


    }
}
