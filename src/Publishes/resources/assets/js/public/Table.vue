<template>
    <div class="my-table">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="operation-checkbox" v-if="config.destroyUrl && config['operation']">
                        <input type="checkbox" v-model="isCheckAll" @change="changeAll(isCheckAll)">
                    </th>
                    <slot name="header" :sorder="swichOrder" :order="order" :fields="config['fields']">
                        <th v-for="(item,key) in config['fields']" :class="item['class'] ? item['class']:''">
                            {{ item.name }}
                            <span v-if="item.order" class="glyphicon" @click="swichOrder(item.orderField ? item.orderField : key)" :class="{'glyphicon-sort':!order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':order[item.orderField ? item.orderField : key]=='asc'}"></span>
                        </th>
                    </slot>
                    <th v-if="config['operation']" class="operation" :class="config.operationClass">
                        操作
                    </th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in items">
                <td v-if="config.destroyUrl && config['operation']">
                    <slot name="checkbox" :item="item" :ids="ids" :changeIds="changeIds">
                        <input type="checkbox" @change="changeIds" v-model="ids" :value="item['id']">
                    </slot>
                </td>
                <slot name="item" :item="item" :index="index" :fields="config['fields']">
                    <td v-for="(value,key) in config['fields']">{{ item[key] }}</td>
                </slot>
                <td v-if="config['operation']">
                    <slot name="operation" :config="config" :destroyId="destroyId" :item="item">
                        <button v-if="config.destroyUrl" @click="destroyId(item['id'])" title="删除选中" type="button" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <a title="编辑" class="btn btn-info btn-xs" v-if="config.editUrl" :href="config.editUrl+'/'+item['id']" target="_blank">
                            <i class="fa fa-edit"></i>
                        </a>
                    </slot>
                </td>
            </tr>
            <tr v-show="!total" class="none-data">
                <td :colspan="col">没有数据</td>
            </tr>
            </tbody>
        </table>
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
            },
            //数据源
            ftxData: {
                type:[Object,Array],
                default: function () {
                    return [];
                }
            },
            checkall:{
                default: function () {
                    return false;
                }
            },
            selectedids:{
                default: function () {
                    return [];
                }
            }
        },
        data: function () {
            return {
                //默认配置
                defaultConfig: {
                    dataUrl:'', //数据请求地址
                    editUrl:'', //编辑地址
                    destroyUrl:'' ,//删除数据地址
                    primaryKey:'id', //数据主键
                    fields:false, //默认显示全部字段
                    operation:false, //是否显示操作列
                    operationClass:'' //操作样式
                },
                dialogFormVisible:false,
                //加载中,防止重复点击
                loading:false,
                row:{},
                isCheckAll:this.checkall,
                ids: this.selectedids
            };
        },
        computed: {
            items:function(){
                return this.ftxData;
            },

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
            //数据总条数
            total:function(){
                if(typeof this.ftxData=="object"){
                    return Object.keys(this.ftxData).length;
                }
                return this.ftxData.length;
            },
            order:function(){
                return this.ftxParams.order;
            },
            col(){
                var arr = Object.keys(this.config['fields']);
                var len = arr.length;
                if(this.config['operation']){
                    len +=1;
                }
                if(this.config.destroyUrl && this.config['operation']){
                    len +=1;
                }
                return len;
            }
        },
        methods:{
            //切换排序
            swichOrder:function(key){
                if(this.loading){
                    return false;
                }
                this.loading = true;
                var order = {};
                if(!this.order[key]){
                    order[key] = 'desc';
                }else if(this.order[key]=='asc'){
                    order[key] = 'desc';
                }else {
                    order[key] = 'asc';
                }
                //将key放到最前面
                for(var i in this.order){
                    if(key!=i){
                        order[i] = this.order[i];
                    }
                }

                var options = {
                    order:order,
                    where:this.ftxParams.where
                };
                var $this = this;
                axios.get(this.config['dataUrl'],{
                    params: options
                }).then(function(response){
                    //改变父组件数据源
                    $this.$emit('http-succeed',response.data);
                    //恢复原来排序规则
                    $this.$emit('update-option','order',order);
                    $this.loading = false;
                }).catch(function(err){
                    $this.loading = false;
                });
            },
            destroyId(id){ //删除数据
                this.$emit('destroy-id',id);
            },
            changeIds(){
                this.$emit('update-ids',this.ids);
            },
            look(index){
                this.row = this.items[index];
                this.dialogFormVisible = true;
            },
            changeAll(val){
                this.$emit('change-all',val);
            }
        },
        watch:{
            checkall(value){
                this.isCheckAll = value;
            },
            selectedids(value){
                this.ids= value;
            }
        }
    }
</script>

