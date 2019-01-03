<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-5
 * 时间: 上午10:26
 * 自定义辅助函数
 */

/**
 * 判断是否可以跳转页面
 * ajax,jsonp,script等请求不予跳转
 * 返回: bool
 */
function canRedirect(){
    $request = app('request');
    return !($request->has('callback') || $request->has('script')  || $request->has('json') ||
        $request->has('define') || $request->ajax() || $request->wantsJson() || $request->has('dd'));
}

/**
 * 可能跳转重定向页面
 * ajax,jsonp,script等请求不予跳转
 *
 * 参数 null $to
 * 参数 int $status
 * 返回: \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
 */
function orRedirect($to = null, $status = 302){
    if(canRedirect()){
        return redirect($to,$status);
    }

    return \Illuminate\Support\Facades\Response::returns([
        'title'=>\Illuminate\Support\Facades\Lang::get('status.status302'),
        'content'=>\Illuminate\Support\Facades\Lang::get('status.redirectTo').$to,
        'redirect' => $to
    ]);
}

/**
 * 获取用户缓存信息
 * param string $key
 * 返回: mixed
 */
function getUserInfo($key=''){
    $key and $key = '.'.$key;
    //session过期,重新缓存
    //if(!session('userInfo')){
    app('user.logic')->loginCacheInfo();
    //}
    return session('userInfo'.$key);
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'parent_id', $child = 'childs', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

function tree_to_list($datas,$ckey = 'children',&$result = []){
    if(!is_array($datas)){
        return $datas;
    }else{
        foreach($datas as $data){
            if(!isset($data[$ckey])){
                $result[] = $data;
            }else{
                $chileds = $data[$ckey];
                unset($data[$ckey]);
                $result[] = $data;
                tree_to_list($chileds,$ckey,$result);
            }
        }
    }
    return $result;
}

function generateTree2($rows, $id='id', $pid='parent_id'){
    $items = array();
    foreach ($rows as $row) $items[$row[$id]] = $row;
    foreach ($items as $item) $items[$item[$pid]]['son'][$item[$id]] = &$items[$item[$id]];
    return isset($items[0]['son']) ? $items[0]['son'] : array();
}

function getModule(){
    return collect(explode('/',app('request')->getPathInfo()))->filter()->first();
}

if (! function_exists('menv')) {
    /**
     * Gets the value of an environment variable by getenv() or $_ENV.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function menv($key, $default = null)
    {
        $value = env($key);
        if(!is_null($value)){
            return $value;
        }elseif (isset($_ENV[$key])) {
            $value = $_ENV[$key];
        } elseif (isset($_SERVER[$key])) {
            $value = $_SERVER[$key];
        }
        return is_null($value) ? value($default) : $value;
    }
}

if (! function_exists('num_random')) {
    /**
     * 数字随机数
     * @param int $length 长度
     * @return int|string 固定长度的字符串
     */
    function num_random($length = 4){
        $res = rand(0,pow(10,$length)-1);
        $length_diff = $length-strlen($res);
        for($i=0;$i<$length_diff;$i++){
            $res = '0'.$res;
        }
        return $res;
    }

}



if (! function_exists('excelDate')) {
    /***
     * excel导入的时间格式处理
     * @param $date
     * @return mixed|string|null
     */
    function excelDate($date){
        if(!$date){
            return null;
        }elseif (gettype($date)=='object'){ //时间对象
            $date = $date->toDateString();
        }elseif (is_numeric($date)){
            if(strlen($date)==6 && checkdate(substr($date,0,4),substr($date,4,2),'01')){
                $date = substr($date,0,4).'-'.substr($date,4,2);
            }else{
                $date = gmdate('Y-m-d',intval(($date - 25569) * 3600 * 24));//格式化时间,不是用date哦, 时区相差8小时的
            }
        }elseif(str_contains($date,'.')){
            $date = str_replace('.','-',$date);
        }elseif(str_contains($date,'/')){
            $date = str_replace('/','-',$date);
        }elseif(!str_contains($date,'-') && strlen($date)==8){
            $date = substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2);
        }
        if(count(explode('-',$date))<3){
            $date = $date.'-01';
        }
        if($date){
            $date_array = explode('-',str_replace(' 00:00:00','',$date));
            if(!strtotime($date) || !checkdate(array_get($date_array,1),array_get($date_array,2),array_get($date_array,0))){ //错误时间格式
                $date = null;
            }
        }
        return $date;
    }
}








