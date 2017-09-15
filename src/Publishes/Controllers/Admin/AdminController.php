<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;
use Resource\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    use ResourceController;

    /**
     * 筛选过滤
     * @var array
     */
    protected $sizer = [
        'user.name|user.uname|user.mobile_phone|user.email' => 'like',
        'roles.name'=>'like',
        'user.status' => '=',
        'roles.id'=>'=',
        'created_at' => [
            '>=',
            '<='
        ]
    ];

    //其它输出
    protected $otherSizerOutput = [
        'key' => 'user.name|user.uname|user.mobile_phone|user.email'
    ];

    //默认排序
    protected $orderDefault = [
        'updated_at' => 'desc',
        'id'=>'asc'
    ];
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Admin';

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'user' => ['id', 'uname', 'name', 'email', 'mobile_phone', 'status']
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $editFields = [
        'user' => [],
        'roles'=>['id']
    ];

    public $exportFields=[
        'user'=>[]
    ];

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id', 0);
        $user_id = Request::input('user.id',0);
        //没有密码值不对密码进行修改
        if(!Request::input('user.password')){
            $user = Request::input('user');
            unset($user['password']);
            Request::offsetSet('user',$user);
        }
        if(!Request::input('user_id')){
            Request::offsetUnset('user_id');
        }
        return [
            'user_id' => 'sometimes|exists:users,id|unique:admins,user_id,' . $id . ',id,deleted_at,NULL',
            'user.uname' => 'sometimes|required|alpha_dash|between:6,18|unique:users,uname,' . $user_id . ',id,deleted_at,NULL',
            'user.password' => 'sometimes|required|between:6,18',
            'user.name' => 'required',
            'user.email' => 'nullable|email|unique:users,email,' . $user_id . ',id,deleted_at,NULL',
            'user.mobile_phone' => 'sometimes|required|mobile_phone|unique:users,mobile_phone,' . $user_id . ',id,deleted_at,NULL',
            'user.qq' => 'nullable|integer|unique:users,qq,' . $user_id . ',id,deleted_at,NULL',
            'user.status' => 'nullable|in:0,1,2'
        ];
    }



    /**
     * 列表页面
     * @return mixed
     */
    public function index()
    {
        //查询数据结果
        $data['list'] = $this->getList();
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->showIndexFields,$this->newBindModel());
        $data['maps']['keywords'] = [
            'user.name|user.uname|user.mobile_phone|user.email'=>'用户信息',
            'roles.name'=>'角色名称'
        ];

        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl();
        //条件筛选及排序返回
        $this->addOptions();
        //数据返回
        return Response::returns($data);
    }


    /**
     * 编辑页面
     */
    public function edit($id = null)
    {
        $data['row'] = $this->getOne($id);
        if(!$id){
            $data['row']['roles'] = [];
        }
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->editFields,$this->newBindModel());
        $data['maps']['roles'] = $this->getRoles($id);
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl('edit');
        return Response::returns($data); //获取一条记录
    }

    /**
     * 执行修改或添加
     */
    public function postEdit(\Illuminate\Http\Request $request)
    {
        $this->validate($request, $this->getValidateRule());//验证数据
        $id = $request->get('id');
        $this->bindModel OR $this->bindModel(); //绑定模型
        $data = $id ? $request->all() : $request->except('id');
        if ($id) {
            $row = $this->bindModel->find($id);
            $res = $row->update($data);
            if ($res === false) {
                return Response::returns(['alert' => alert(['message' => '修改失败!'], 500)]);
            }
            $row->roles()->sync(collect($data['roles'])->pluck('id')->toArray());
            $row->user->update($data['user']);
            return Response::returns(['alert' => alert(['message' => '修改成功!'])]);
        }

        //新增
        $res = $this->bindModel->create($data);
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '新增失败!'], 500)]);
        }
        if(array_get($data,'user_id')){
            $res->user->update($data['user']);
        }else{
            factory(\App\User::class)->create($data['user'])
                ->admin()
                ->save($res);
        }
        $res->roles()->sync(collect($data['roles'])->pluck('id')->toArray());
        return Response::returns(['alert' => alert(['message' => '新增成功!'])]);
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all = false, $id = true)
    {
        $res = app('user.logic')->getAdminRolesAndChilds($all);
        return $id ? $res->pluck('id')->toArray() : $res->toArray();
    }

    /**
     * 获取用户角色
     * @param $id
     * @return mixed
     */
    public function getRoles($id)
    {
        if ($id) {
            $admin = $this->newBindModel()->find($id);
            $has_roles = isset($admin->roles) ? $admin->roles : collect([]);
        } else {
            $has_roles = collect([]);
        }

        //获取当前用户所有下属角色
        $self_roles = $this->rolesChildsId(app('user.logic')->getUserInfo('isSuperAdmin'));
        //列出所有角色,当前用户不可操作的角色禁用
        return Role::orderBy('left_margin')
            ->get()
            ->each(function ($item) use ($self_roles, $has_roles) {
                $item->checked = in_array($item->id, $has_roles->pluck('id')->toArray()); //当前用户拥有角色
                $item->disabled = !in_array($item->id, $self_roles); //添加用户角色是否可用
                $item->chkDisabled = $item->disabled;
            });
    }

    /**
     * 导入数据
     */
    public function import(){
        ini_set ('memory_limit', -1);
        ini_set('max_execution_time', '0');
        //上传excel文件路径
        if(!app('request')->file('excel')){
            dd('请先选择EXCEL文件');
        }
        $filePath = app('request')->file('excel')->getRealPath();
        Excel::load($filePath, function($reader){
            $this->verifyImport($reader);
            $now = date('Y-m-d H:i:s'); //当前时间
            $maps = $this->getFieldsMap($this->exportFields,$this->newBindModel());
            $default = $this->editDefaultFields($this->exportFields,$this->newBindModel());
            $datas = $reader->all()->forget(0)->filter(function($item){ //过滤全部为空的数据
                $flog = false;
                foreach($item as $value){
                    $value and $flog=true;
                }
                return $flog;
            })->map(function($item)use($maps,$default){
                return collect($item)->map(function($item,$key)use($maps,$default){
                    $map = array_get($maps,$key);
                    if($map){
                        $value = trim(array_get(array_flip($map),$item));
                    }else{
                        $value = is_null($item) ? array_get($default,$key) : trim($item);
                    }
                    return $value;
                })->toArray();
            })->toArray(); //读取数据
            $key_name = $this->newBindModel()->getKeyName();
            $bindModel = $this->getModelNamespace() . $this->getResourceModel();
            foreach($datas as $row){
                $row = getRelationData($row); //关联数据
                if(!array_get($row,'user.password')){ //修改密码
                    unset($row['user']['password']);
                }
                $user_id = array_get($row['user'],'id');
                $user = User::updateOrCreate($user_id?['id'=>$user_id]:['uname'=>array_get($row['user'],'uname')],$row['user']);
                $row['user_id'] = $user['id'];
                $admin_id = array_get($row,$key_name);
                $bindModel::updateOrCreate($admin_id ? [$key_name=>$admin_id] : ['user_id'=>$user['id']],$row);
            }
            dd('处理完成');
        });
    }
}
