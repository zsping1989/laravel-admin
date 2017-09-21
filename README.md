l
aravel-admin
=====

[![Packagist](https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000)](https://packagist.org/packages/zsping1989/laravel-admin)
[![Total Downloads](https://img.shields.io/packagist/dt/zsping1989/laravel-admin.svg?style=flat-square)](https://packagist.org/packages/zsping1989/laravel-admin)
[![Awesome Laravel](https://img.shields.io/badge/Awesome-Laravel-brightgreen.svg)](https://github.com/zsping1989/laravel-admin)

`laravel-admin` 是一个可以快速帮你构建后台管理的工具，它提供的页面组件和表单元素等功能，能帮助你使用很少的代码就实现功能完善的后台管理功能。

[Demo](#)
[阅读文档](https://zsping1989.gitbooks.io/laravel-admin/)


Screenshots
------------

![laravel-admin](http://a3.qpic.cn/psb?/V11BOt0S4MAKLC/*2yXcoVB6gN0.TXBVaruF3sBJdTsh4KyWII*cZPn*0g!/b/dPIAAAAAAAAA&bo=.gROAwAAAAACa*w!&rf=viewer_4)

安装
------------

**要求:**

一. php >=7.0

二. 安装好composer

三. 安装好npm(建议使用国内镜像cnpm,安装速度更快)

四. 安装好laravel/framework: 5.5.*


**步骤**

> 先安装laravel项目代码库

```
laravel new laravel-admin

cd laravel-admin
```
> 通过composer进行安装laravel-admin

```
composer require zsping1989/laravel-admin
```

> 安装完成后执行发布代码命令(该命令将在项目中生成控制器,模型,迁移,初始填充数据等)

```
php artisan laravel-admin:publish
```

> 下一步参照.env.example配置文件配置.env,
> 执行生成配置文件中的APP_KEY命令

```
php artisan key:generate
```

> 下一步执行

```
composer dump
```

> 系统安装(数据库建表及数据填充)

```
php artisan migrate --seed
```

> 前端js组件下载安装

```
npm install
```

> 对前端页面组件进行编译

```
npm run production
```

**安装好后在编辑器里将public和node_modules目录标记为排除,不然编辑器会卡死,到此laravel-admin已经安装完成了**