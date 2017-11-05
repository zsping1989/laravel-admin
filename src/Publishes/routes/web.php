<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',function(){
    return redirect('/home/index');
});

//前台无需登录路由
Route::group(['prefix'=>'open','namespace'=>'Open'],function(){
    Route::get('index', 'IndexController@index'); //主页
    Route::get('login', 'LoginController@showLoginForm')->name('login'); //登录页面
    Route::get('other-login/{type}', 'LoginController@otherLogin'); //三方登录
    Route::get('other-login-callback/{type}', 'LoginController@otherLoginCallback'); //三方登录后回调
    Route::post('login', 'LoginController@login'); //执行登录
    Route::post('logout', 'LoginController@logout')->name('logout'); //退出登录
    Route::get('geetest', 'LoginController@getGeetest'); //获取验证码
    Route::post('register/send-sms', 'RegisterController@sendSMS'); //发送用户注册短信
    Route::post('register', 'RegisterController@register'); //提交注册
    Route::get('activate-by-email', 'RegisterController@activateByEmail')->name('activate'); //通过邮件激活用户
    //Route::get('php-info', 'IndexController@phpInfo'); //php详情
});

//前端路由
Route::group(['prefix'=>'home','namespace'=>'Home','middleware'=>['auth','activated']],function(){
    Route::get('index', 'IndexController@index'); //个人主页
    Route::get('personage/password', 'PersonageController@password'); //密码修改
    Route::post('personage/password', 'PersonageController@postPassword'); //执行密码修改
    Route::get('personage/index', 'PersonageController@index'); //个人资料
    Route::post('personage/index', 'PersonageController@postIndex'); //个人资料
    createRessorceRoute('notification','NotificationController',['only'=>['index','list','show','destroy']]); //消息通知

});


//后台路由
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','activated','admin']],function(){
    Route::get('index', 'IndexController@index'); //后台主页
    createRessorceRoute('area','AreaController');
    createRessorceRoute('user','UserController');
    createRessorceRoute('role','RoleController');
    createRessorceRoute('log','LogController',['except'=>['edit','import']]);
    createRessorceRoute('menu','MenuController');
    createRessorceRoute('config','ConfigController');
    createRessorceRoute('admin','AdminController');
    createRessorceRoute('notification','NotificationController',['only'=>['index','list','show','destroy']]);
    Route::get('tolead/index', 'ToleadController@index');
    Route::get('personage/password', 'PersonageController@password'); //密码修改
    Route::get('personage/index', 'PersonageController@index'); //个人资料
});



