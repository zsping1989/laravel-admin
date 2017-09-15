<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ResourceController;
    //默认排序
    protected $orderDefault = [
        'updated_at' => 'desc',
        'id'=>'asc'
    ];
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'User';

    /**
     * 筛选过滤
     * @var array
     */
    protected $sizer = [
        'name|uname|mobile_phone|email' => 'like',
        'status' => '=',
        'created_at' => [
            '>=',
            '<='
        ]
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'uname',
        'name',
        'mobile_phone',
        'email',
        'qq',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * 编辑页面时的字段值
     * @var array
     */
    public $editFields = [];

    /**
     * 添加或修改时数据验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id',0);
        //没有密码值不对密码进行修改
        if(!Request::input('password')){
            Request::offsetUnset('password');
        }
        return [
            'uname' => 'sometimes|required|alpha_dash|between:6,18|unique:users,uname,'.$id.',id,deleted_at,NULL',
            'password' => 'sometimes|required|between:6,18',
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
            'mobile_phone' => 'sometimes|required|mobile_phone|unique:users,mobile_phone,'.$id.',id,deleted_at,NULL',
            'qq' => 'nullable|integer|unique:users,qq,'.$id.',id,deleted_at,NULL',
            'status'=>'nullable|in:0,1,2'
        ];
    }

    /**
     * 获取条件拼接对象
     * @return mixed
     */
    public function getWithOptionModel()
    {
        $this->bindModel OR $this->bindModel();
        $obj = $this->bindModel->with($this->selectWithFields())
            ->withCount(collect($this->getShowIndexFieldsCount())->filter(function($item,$key){
                return !is_array($item);
            })->toArray())
            ->whereDoesntHave('admin') //不显后台用户
            ->options($this->getOptions());
        return $obj;
    }

}
