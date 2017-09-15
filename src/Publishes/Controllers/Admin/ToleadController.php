<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ToleadController extends Controller
{
    /**
     * 批量导入页面
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'row'=>[
                'url'=>'',
                'selected'=>0
            ],
            'maps'=>[
                'options'=>[
                    [
                        'name'=>'数据导入或修改',
                        'values'=>[
                            ['name'=>'后台角色数据','url'=>'/admin/role/import'],
                            ['name'=>'后台用户数据','url'=>'/admin/admin/import']
                        ]
                    ],
                    [
                        'name'=>'其它数据项',
                        'values'=>[
                            ['name'=>'系统设置数据','url'=>'/admin/config/import'],
                            ['name'=>'菜单数据','url'=>'/admin/menu/import'],
                            ['name'=>'普通用户数据','url'=>'/admin/user/import']
                        ]
                    ]
                ]
            ],
            'token'=>csrf_token()
        ];
        return Response::returns($data);
    }




}
