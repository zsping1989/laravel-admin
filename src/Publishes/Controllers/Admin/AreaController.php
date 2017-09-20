<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Resource\Controllers\ResourceController;

class AreaController extends Controller
{
    //资源控制器
    use ResourceController;

    protected $modelNamespace = 'Resource\\Models\\';

    /**
     * 资源模型
     * @var string
     */
    protected $resourceModel = 'Area';

    /**
     * 过滤器筛选条件
     * @var array
     */
    protected $sizer = ['name'=>'like'];

    /**
     * 默认排序规则
     * @var array
     */
    protected $orderDefault=['updated_at'=>'desc'];

    /**
     * 验证规则获取
     * 返回: array
     */
    protected function getValidateRule(){
        return [
            'name' => 'required',
            'parent_id' => 'sometimes|required|exists:areas,id',
        ];
    }





}
