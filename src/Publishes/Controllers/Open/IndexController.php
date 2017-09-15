<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/open/login');
        return '<h1><a href="/open/login">进入系统</a></h1>';
    }

    public function phpInfo(){
        phpinfo();
    }


}
