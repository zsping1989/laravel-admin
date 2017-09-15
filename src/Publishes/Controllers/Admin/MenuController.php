<?php

namespace App\Http\Controllers\Admin;

use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Response;

class MenuController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Menu';

    protected $orderDefault=[
        'left_margin'=>'asc',
        'id'=>'asc'
    ];

    protected $sizer = [
        'name' => 'like',
        'status' => '=',
        'is_page' => '=',
        'method' => '&'
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'id', 'icons', 'name', 'url', 'parent_id', 'level', 'method', 'is_page', 'status', 'parent' => ['name', 'id'], 'created_at', 'updated_at'
    ];

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return [
            'name' => 'required',
            'icons' => 'nullable|alpha_dash',
            'parent_id' => 'sometimes|required|exists:menus,id',
            'method' => 'required|array',
            'is_page' => 'in:0,1',
            'status' => 'in:1,2'
        ];
    }

    /**
     * 编辑页面
     */
    public function edit($id = null)
    {
        $data['row'] = $this->getOne($id);
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->editFields,$this->newBindModel());
        //查询可选择的父级角色
        $data['maps']['optional_parents'] = Menu::optionalParent($id ? $data['row'] : null)
            ->orderBy('left_margin', 'asc')
            ->get(['id','name','icons','parent_id','level','left_margin','right_margin']);
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl('edit');
        return Response::returns($data); //获取一条记录
    }


}
