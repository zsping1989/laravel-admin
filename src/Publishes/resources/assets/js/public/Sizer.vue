<template>
<div class="sizer">
    <form :action="config['exportUrl']" method="get">
        <input v-for="(item,key) in exportOptions" type="hidden" :name="key" v-model="exportOptions[key]">
        <slot :where="where" :change-date="changeDate">
            <div class="input-group input-group-sm" style="width:165px;">
                <input class="form-control" v-model="where.id" placeholder="请输入关键字" type="text">
            </div>
        </slot>
        <div class="input-group input-group-sm">
            <div class="input-group-btn">
                <slot name="tool" :config="config" :getData="getData" :resetData="reset" :where="where" >
                    <button @click="getData()" type="button" class="btn btn-default" title="搜索" ><i class="fa fa-search"></i></button>
                    <button @click="reset()" type="button" class="btn btn-default" title="重置"><i class="fa fa-repeat"></i></button>
                    <button v-if="config['exportUrl']" type="submit" class="btn btn-default" title="导出EXCEL"><i class="fa fa-file-excel-o"></i></button>
                </slot>
            </div>
        </div>
    </form>
</div>
</template>

<script>
    export default {
        props: {
            //默认参数
            ftxParams:{
                type:Object,
                default: function () {
                    return {where:[],order:{}};
                }
            },
            //过滤配置项
            ftxConfig: {
                type:Object,
                default: function () {
                    return {};
                }
            }
        },
        data: function () {
            var where = JSON.parse(JSON.stringify(this.ftxParams.where || []));
            var options = JSON.parse(JSON.stringify(this.ftxParams));
            options.where = options.where || [];
            options.order = options.order || [];
            return {
                //初始options
                options:options,
                //默认配置
                defaultConfig: {
                    dataUrl:'', //数据请求地址
                    exportUrl:'', //导出数据地址
                    search:true //搜索框
                },
                //筛选条件
                where:where,
                //加载中,防止重复点击
                loading:false,
                formInline:{}
            }
        },
        computed: {
            //当前配置
            config: function () {
                //计算配置
                var config = {};
                //覆盖默认配置
                for(var i in this.defaultConfig){
                    if(typeof this.ftxConfig[i]!='undefined' && this.ftxConfig[i]){
                        config[i] = this.ftxConfig[i];
                    }else {
                        config[i] = this.defaultConfig[i];
                    }
                }
                config['dataUrl'] = config['dataUrl'] || '';
                return config;
            },
            exportOptions(){
                var exportOptions = {};
                for(let i in this.where){
                    if(typeof this.where[i]=="object"){
                        for (let j in this.where[i]){
                            exportOptions['where['+i+']['+j+']'] = this.where[i][j];
                        }
                    }else {
                        exportOptions['where['+i+']'] = this.where[i];
                    }
                }
                for (let i in this.order){
                    exportOptions['order['+i+']'] = this.order[i];
                }
                return exportOptions;
            }
        },

        methods:{
            changeDate(obj,key,value){
                Vue.set(obj,key,value);
            },
            //执行查询
            getData:function(){
                if(this.loading){
                    return false;
                }
                this.loading = true;
                var options = {
                    params:{
                        where:this.where,
                        order:this.ftxParams.order || {}
                    }
                };
                var $this = this;
                //执行翻页
                axios.get(this.config['dataUrl'],options).then(function(response){
                    //改变父组件数据源
                    $this.$emit('http-succeed',response.data);
                    $this.$emit('update-option','where',JSON.parse(JSON.stringify($this.where)));
                    $this.loading = false;
                }).catch(function(error){
                    $this.loading = false;
                });
            },
            //重置
            reset:function(){
                if(this.loading){
                    return false;
                }
                this.loading = true;
                var $this = this;
                //执行翻页
                axios.get(this.config['dataUrl'],{params:this.options}).then(function(response){
                    //重置当前筛选
                    $this.where = $this.copyObj($this.options.where);
                    //改变父组件数据源
                    $this.$emit('http-succeed',response.data);
                    //恢复原来筛选条件
                    $this.$emit('update-option','where',$this.copyObj($this.options.where));
                    //恢复原来排序规则
                    $this.$emit('update-option','order',$this.copyObj($this.options.order));
                    $this.loading = false;
                }).catch(function(error){
                    $this.loading = false;
                });
            },
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            }
        }
    }
</script>

