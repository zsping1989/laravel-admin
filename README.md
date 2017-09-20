# resource
##用途
1. 后台数据表基本的增删改查的实现

## 安装:
**要求:**

一. php >=5.6

二. 安装好composer

三. 安装好cnpm

四. laravel/framework: 5.5.*


**步骤**
```
$ composer require zsping1989/laravel-admin
$ php artisan laravel-admin:publish
$ 修改配置文件.env
$ php artisan key:generate
$ php artisan migrate --seed
$ cnpm install
$ cnpm run watch
```
