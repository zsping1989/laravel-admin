/**
 * Created by zhangshiping on 2017/6/19.
 */
import Vue from 'vue';
/**
 * 全局方法调用
 */
Vue.filter('F', function () {
    var f = eval(arguments[0]);
    arguments.splice = [].splice;
    var p = arguments.splice(1);
    return f.apply(this, p);
});


/**
 * 字符串截取
 * @param value
 * @param limit
 * @param end
 */
Vue.filter('str_limit', function(value,limit,end){
    limit = limit || 100;
    end = typeof end=='undefined' ? '...' : end;
    var _str = value ? String(value):'';
    if(_str.length>limit){
        return _str.substring(0,limit) + end;
    }
    return _str;
});

Vue.filter('deep', function deep(num) {
    var str = '|';
    for (var i = 1; i < num; ++i) {
        str += '—';
    }
    if (num > 1) {
        return str+':';
    }
    return '';
});

/**
 * 小数经度丢失处理
 */
Vue.filter('parse_float', function parse_float(num) {
    return parseFloat((num).toPrecision(12));
});

/**
 * 金额格式化
 */
Vue.filter('currency',function(num,digit,prefix){
    if(typeof digit=='undefined'){
        digit = 0;
    }
    if(typeof prefix=='undefined'){
        prefix = '¥';
    }
    return prefix+Number(num).toFixed(digit);
});

/**
 * 获取多级数据
 */
Vue.filter('array_get',window.array_get = function(arr,key,def){
    //默认值
    def = typeof def=='undefined' ? '' : def;
    if(!arr || !key || (typeof key!='string' && typeof key!='number') || (typeof arr != "object")){
        return def;
    }
    key = String(key);
    if(key.indexOf('.')==-1){
        return typeof arr[key]=="undefined" ? def : arr[key];
    }
    let keys = key.split('.');
    let reslut = arr;
    for (let i in keys){
        if(typeof reslut!="object" || isNull(reslut)){
            return def;
        }
        reslut = reslut[keys[i]];
        if(typeof reslut=="undefined"){
            return def;
        }
    }
    return reslut==='' ? def : reslut;
});

/**
 * 获取次幂数
 */
Vue.filter('pow_opposite',window.pow_opposite = function(num,cardinal_number){
    return Math.log(num)/Math.log(cardinal_number);
});

Vue.filter('checkbox_class',function(num,cardinal_number,statusClass){
    return 'label-'+statusClass[(Math.log(num)/Math.log(cardinal_number)+1)%statusClass.length];
});