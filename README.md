laravel-admin
=====

[![Packagist](https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000)](https://packagist.org/packages/zsping1989/laravel-admin)
[![Total Downloads](https://img.shields.io/packagist/dt/zsping1989/laravel-admin.svg?style=flat-square)](https://packagist.org/packages/zsping1989/laravel-admin)
[![Awesome Laravel](https://img.shields.io/badge/Awesome-Laravel-brightgreen.svg)](https://github.com/zsping1989/laravel-admin)

`laravel-admin` 是一个可以快速帮你构建后台管理的工具，它提供的页面组件和表单元素等功能，能帮助你使用很少的代码就实现功能完善的后台管理功能。

[Demo](#)
[阅读文档](https://zsping1989.gitbooks.io/laravel-admin/)


Screenshots
------------

![laravel-admin](http://chuantu.biz/t6/57/1505986853x3062523156.gif)

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

# 数据表
![navicat建表](https://zsping1989.gitbooks.io/laravel-admin/content/assets/QQ图片20170926163747.png)

```sql
CREATE TABLE `tests` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
`user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID$select2',
`name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
`password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码$password@sometimes|required|digits_between:6,18',
`email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '电子邮箱$email@sometimes|required|email|unique:tests,email',
`is_page` int(11) NOT NULL DEFAULT '0' COMMENT '是否为页面:0-否,1-是$radio@in:0,1',
`status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态:1-显示,2-不显示$select@in:1,2',
`icons` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图标$icon@nullable|alpha_dash',
`method` int(11) NOT NULL DEFAULT '1' COMMENT '请求方式:1-get,2-post,4-put,8-delete,16-head,32-options,64-trace,128-connect$checkbox@required|array',
`date_at` date DEFAULT NULL COMMENT '日期$date',
`month_at` date DEFAULT NULL COMMENT '月份$month',
`time` varchar(255) NOT NULL DEFAULT '' COMMENT '时间选择器$timeSelect',
`time_picker` varchar(255) NOT NULL DEFAULT '' COMMENT '时间到秒$timePicker',
`color` varchar(255) NOT NULL DEFAULT '' COMMENT '颜色选择器$color',
`switch` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '开关$switch',
`slider` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '滑块$slider',
`rate` double(10,0) unsigned NOT NULL DEFAULT '0' COMMENT '评分星星$rate',
`num` int(11) NOT NULL DEFAULT '0' COMMENT '数字$num',
`description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述$textarea',
`img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片$upload',
`ueditor` text COMMENT '百度编辑器$ueditor',
`parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID$ztree@nullable|exists:tests,id',
`level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
`left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
`right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL,
`deleted_at` timestamp NULL DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `tests_parent_id_index` (`parent_id`),
KEY `tests_left_margin_index` (`left_margin`),
KEY `tests_right_margin_index` (`right_margin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='测试$softDeletes,timestamps,treeModel@belongsTo:user';

```
# 生成结果
![编辑页面](https://zsping1989.gitbooks.io/laravel-admin/content/assets/QQ图片20170926165257.png)
![列表页面](https://zsping1989.gitbooks.io/laravel-admin/content/assets/QQ图片20170926165917.png)