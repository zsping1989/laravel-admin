<?php

namespace App\Http\Controllers\Admin;

use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Support\Facades\Response;

class LogController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Log';

    protected $sizer=[
        'menu.name'=>'like'
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'user'=>['id','name'],
        'menu'=>['id','name']
    ];
    public $editFields = [
        'user'=>['id','name'],
        'menu'=>['id','name']
    ];

    protected $orderDefault = [
        'created_at'=>'desc',
        'id'=>'asc'
    ];

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return [];
    }


}
