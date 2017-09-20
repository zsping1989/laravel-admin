<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use LaravelAdmin\Facades\Option;

class IndexController extends Controller
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

    /**
     * 饼状图数据
     * @return mixed
     */
    protected function gradeRatio(){
        $str = '{"legend":["总公司(47人)","分公司(3人)","成都公司(3人)","北京公司(263人)","深圳公司(169人)","上海公司(432人)","广州公司(631人)"],"series":[{"name":"总公司(47人)","value":47},{"name":"分公司(3人)","value":3},{"name":"成都公司(3人)","value":3},{"name":"北京公司(263人)","value":263},{"name":"深圳公司(169人)","value":169},{"name":"上海公司(432人)","value":432},{"name":"广州公司(631人)","value":631}],"max":631}';
        return json_decode($str,true);
    }

}
