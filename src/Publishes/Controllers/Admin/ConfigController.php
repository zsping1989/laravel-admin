<?php

namespace App\Http\Controllers\Admin;

use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Support\Facades\Response;

class ConfigController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Config';
    protected $sizer=[
        'name'=>'like'
    ];
    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return [
            'name' => 'required',
            'key' => 'required',
            'value' => 'required'
        ];
    }


}
