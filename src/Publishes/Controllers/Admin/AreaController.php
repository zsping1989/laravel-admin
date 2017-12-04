<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Resource\Controllers\ResourceController;
use Resource\Facades\Data;
use Resource\Models\Area;

class AreaController extends Controller
{
    //资源控制器
    use ResourceController;

    protected $modelNamespace = '\\Resource\\Models\\';

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
    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'parent'=>['id','name']
    ];

    /**
     * 编辑页面
     */
    public function edit($id = null)
    {
        $data['row'] = $this->getOne($id);
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->editFields,$this->newBindModel());
        $data['maps']['parent_id'] = mapOption($data['row'],'parent_id');
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl('edit');
        return Response::returns($data); //获取一条记录
    }

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $searchFields = [
        'id','name','parent_id',
        'parent'=>['id','name']
    ];

    /**
     * 可选的推荐人
     */
    public function optionalParent($id=null){
        //获取带有筛选条件的对象
        $obj = $this->getWithOptionModel('searchFields')
            ->optionalParent($id ? Area::find($id) : null)
            ->orderBy('left_margin', 'asc');
        //指定查询字段
        $fields = $this->selectFields($this->searchFields);
        $fields and $obj->select(in_array($this->newBindModel()->getKeyName(),$fields)?$fields:array_merge([$this->newBindModel()->getKeyName()],$fields));
        //获取分页数据
        $data = $obj->paginate()->toArray();
        $data['data'] = collect($data['data'])->map(function($item){
            $text = array_get($item,'name');
            $text .= array_get($item,'parent.name')? '（'.array_get($item,'parent.name').'）' : '';
            $item['text'] = $text;
            return $item;
        });
        //返回响应数据存放,方便操作日志记录
        Data::set('list', $data);
        return $data;
    }





}
