<?php

namespace LaravelAdmin\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

            //判断当前路由是否在拥有权限url中
            $hasPermission = app('menu.logic')->isUrlInMenus($route,$menus);;

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
        // 结果成功返回到客户端后执行
    }
}
