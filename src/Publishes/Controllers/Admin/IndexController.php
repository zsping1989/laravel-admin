<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Menu;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class IndexController extends \App\Http\Controllers\Home\IndexController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::returns([
            'grades'=>$this->gradeRatio()
        ]);
    }


}
