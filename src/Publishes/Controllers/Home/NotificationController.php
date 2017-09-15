<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin;
use App\Models\Notification;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use LaravelAdmin\Facades\UserLogic;
use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Response;
use Resource\Facades\Data;

class NotificationController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Notification';

    /**
     * 是否检查用户拥护的url权限
     * 获取Index页面的url配置地址
     * @var bool
     */
    protected $checkPermission = false;

    public $sizer = [
        'data'=>'like',
        'read_at'=>'null',
        'type'=>'='
    ];

    //默认排序
    protected $orderDefault=[
        'read_at'=>'asc',
        'created_at'=>'desc',
        'id'=>'asc'
    ];

    /**
     * 绑定模型
     * @return mixed
     */
    public function bindModel()
    {
        if (!$this->bindModel) {
            $this->bindModel = UserLogic::getUser()->notifications();
        }
        return $this->bindModel;
    }



    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return [];
    }

    /**
     * 获取翻页数据
     */
    public function getList()
    {
        //获取带有筛选条件的对象
        $obj = $this->getWithOptionModel();
        //指定查询字段
        $fields = $this->selectFields($this->showIndexFields);
        $fields and $obj->select(in_array($this->newBindModel()->getKeyName(),$fields)?$fields:array_merge([$this->newBindModel()->getKeyName()],$fields));
        //获取分页数据
        $now = new Carbon();
        $data = $obj->paginate()->toArray();

        //获取未读总记录条数
        $no_read_count = Notification::where('notifiable_type','App\User')
            ->where('notifiable_id',array_get(UserLogic::getUser(),'id'))
            ->whereNull('read_at')
            ->groupBy('type')
            ->selectRaw('type,COUNT(*) AS `count`')
            ->pluck('count','type');
        $data['no_read_count'] = [
            'total'=>collect($no_read_count)->sum(),
            'data'=>$no_read_count
        ];
        $data['data'] = collect($data['data'])->map(function($item)use($now){
            $item['diff_time'] = (new Carbon($item['created_at']))->diffForHumans($now);
            return $item;
        });
        //返回响应数据存放,方便操作日志记录
        Data::set('list', $data);
        return $data;
    }


    /**
     * 获取一条编辑数据
     * @param null $id
     * @return \stdClass
     */
    public function getOne($id = null)
    {
        $this->bindModel OR $this->bindModel(); //绑定模型
        if($id){
            $data = $this->bindModel
                ->with($this->selectWithEidtFields('editFields'))->findOrFail($id);
            $data->markAsRead(); //标记为已读
            return $data;
        }else{
            return $this->editDefaultFields($this->editFields,$this->newBindModel());
        }

    }

    /**
     * 删除数据
     * @return mixed
     */
    public function postDestroy()
    {
        $this->bindModel OR $this->bindModel(); //绑定模型
        $res = $this->bindModel->whereIn('id',Request::input('ids', []))->delete();
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '删除失败!'], 500)]);
        }
        return Response::returns(['alert' => alert(['message' => '删除成功!'])]);
    }


}
