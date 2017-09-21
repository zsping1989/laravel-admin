<?php

namespace LaravelAdmin\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LaravelAdmin\Logics\UserLogicService;
use LaravelAdmin\Logics\MenuLogicService;
use LaravelAdmin\Services\OptionRepository;

class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param  ResponseFactory  $factory
     * @return void
     */
    public function boot()
    {
        //需要发布的代码
        $this->publishes([
            __DIR__.'/../Publishes/configs' => config_path(), //配置文件
            __DIR__.'/../Publishes/Controllers' => app_path('Http/Controllers'), //控制器
            __DIR__.'/../Publishes/database' => database_path(), //表迁徙及填充文件
            __DIR__.'/../Publishes/Middleware' => app_path('Http/Middleware'), //中间件注册
            __DIR__.'/../Publishes/Models' => app_path('Models'), //模型
            __DIR__.'/../Publishes/Notifications' => app_path('Notifications'), //消息通知
            __DIR__.'/../Publishes/public' => public_path(), //前端样式
            __DIR__.'/../Publishes/resources' => resource_path(), //前端页面
            __DIR__.'/../Publishes/routes' => base_path('routes'), //路由注册
            __DIR__.'/../Publishes/Services' => app_path('Services'), //页面公共数据
            __DIR__.'/../Publishes/User.php' => app_path('User.php'), //用户模型
            __DIR__.'/../Publishes/Kernel.php' => app_path('Http/Kernel.php'), //注册中间件
            __DIR__.'/../Publishes/.env.example' => base_path('.env.example'), //配置事列
            __DIR__.'/../Publishes/package.json' => base_path('package.json'), //前端依赖包
            __DIR__.'/../Publishes/webpack.mix.js' => base_path('webpack.mix.js'), //前端编译配置
        ],'laravel-admin');

        //时间语言设置
        \Carbon\Carbon::setLocale(array_get(explode('-',config('app.locale')),0));
        //Route::pattern('id', '[0-9]+'); //全局路由设置

        //注册创建代码命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                'LaravelAdmin\Console\LaravelAdmimPublish',
            ]);
        }
    }



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //系统配置
        $this->app->singleton('option', OptionRepository::class);
        //用户逻辑
        $this->app->singleton('user.logic', UserLogicService::class);
        //菜单逻辑
        $this->app->singleton('menu.logic', MenuLogicService::class);

    }
}
