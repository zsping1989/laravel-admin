<template>
    <div class="row data-table">
        <div class="col-xs-12">
            <slot :list="list" name="top"></slot>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">筛选条件</h3>
                    <div class="box-tools form-inline pull-right">
                        <sizer :ftx-params="options"
                               :ftx-config="sizerConfig"
                               @http-succeed="updateData"
                               @update-option="updateOption">
                            <template scope="props">
                                <slot name="sizer-where" :where="props.where" :change-date="props.changeDate" :datas="list">
                                    <div class="input-group input-group-sm" style="width:165px;">
                                        <input class="form-control" v-model="props.where.id" placeholder="请输入关键字"
                                               type="text">
                                    </div>
                                </slot>
                            </template>
                            <template scope="props" slot="tool">
                                <slot name="sizer-tool" :config="props.config" :getData="props.getData" :resetData="props.resetData" :where="props.where">
                                    <button @click="props.getData()" type="button" class="btn btn-default" title="搜索" ><i class="fa fa-search"></i></button>
                                    <button @click="props.resetData()" type="button" class="btn btn-default" title="重置"><i class="fa fa-repeat"></i></button>
                                    <button v-if="props.config['exportUrl']" type="submit" class="btn btn-default" title="导出EXCEL"><i class="fa fa-file-excel-o"></i></button>
                                </slot>
                            </template>
                        </sizer>
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table-content :ftx-data="list['data']"
                                               :ftx-params="options"
                                               :ftx-config="tableContentConfig"
                                               :checkall.sync="checkAll"
                                               :selectedids.sync="selected"
                                               @http-succeed="updateData"
                                               @update-option="updateOption"
                                               @update-ids="updateIds"
                                               @change-all="handleCheckAllChange"
                                               @destroy-id="destroyIds">
                                    <template scope="props" slot="header">
                                        <slot is="slot" name="table-content-header" :sorder="props.sorder" :order="props.order" :fields="props.fields">
                                            <th v-for="(item,key) in props.fields" :class="item['class'] ? item['class']:''">
                                                {{ item.name }}
                                                <span v-if="item.order" class="glyphicon" @click="props.sorder(item.orderField ? item.orderField : key)" :class="{'glyphicon-sort':!props.order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':props.order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':props.order[item.orderField ? item.orderField : key]=='asc'}"></span>
                                            </th>
                                        </slot>
                                    </template>
                                    <template scope="props" slot="item">
                                        <slot is="slot" name="table-content-row" :index="props.index" :item="props.item" :fields="props.fields">
                                            <td v-for="(value,key) in props.fields">{{ props.item | array_get(key) }}</td>
                                        </slot>
                                    </template>
                                    <template scope="props" slot="operation">
                                        <slot is="slot" name="table-content-operation" :config="props.config" :item="props.item"  :destroyId="props.destroyId" :selectedIds="selected" :refresh="refresh">
                                            <button v-if="props.config.destroyUrl" @click="props.destroyId(props.item['id'])" title="删除选中" type="button" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            <a title="编辑" class="btn btn-info btn-xs" v-if="props.config.editUrl" :href="props.config.editUrl+'/'+props.item['id']" target="_blank">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </slot>
                                    </template>
                                </table-content>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="btn-group">
                                        <slot is="slot" name="table-footer" :config="config" :destroy="destroy" :selectedIds="selected" :refresh="refresh">
                                            <button v-if="config.destroyUrl" @click="destroy" title="删除选中" type="button"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                            <button @click="refresh(1)" title="刷新" type="button"
                                                    class="btn btn-success btn-sm"><i class="fa fa-refresh"></i></button>
                                            <a title="添加" class="btn btn-primary btn-sm" v-if="config.add && config.editUrl" :href="config.editUrl" target="_blank">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </slot>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <paginate :ftx-data="list"
                                              :ftx-params="options"
                                              :ftx-config="paginateConfig"
                                              @http-succeed="updateData">
                                    </paginate>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import table from './Table.vue';
    import sizer from './Sizer.vue';
    import paginate from './Paginate.vue';
    export default {
        props: {
            //默认参数
            ftxParams: {
                type: Object,
                default: function () {
                    return {where: [], order: {}};
                }
            },
            //过滤配置项
            ftxConfig: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            //数据源
            ftxData: {
                type: [Object, Array],
                default: function () {
                    return [];
                }
            },
            callback:{
                type: [Function],
                default: function () {
                    return function (){};
                }
            }
        },
        components: {
            "table-content": table, //数据表内容
            "sizer": sizer, //数据表过滤器
            "paginate": paginate //数据表分页工具
        },
        data() {
            return {
                list: this.ftxData, //列表数据
                options: this.ftxParams, //筛选条件跟排序
                defaultConfig: { //默认配置
                    dataUrl: '', //数据请求地址
                    editUrl: '', //编辑数据url
                    destroyUrl: '',//删除数据url
                    exportUrl: '',//数据导出url
                    primaryKey: 'id', //数据主键
                    fields: false, //默认显示全部字段
                    operation: false, //操作列
                    add: true, //添加按钮
                    operationClass:'' //操作样式
                },
                checkAll: false, //全选
                selected: [], //选择值
                loading: false //是否在请求中
            }
        },
        computed: {
            config: function () { //当前配置
                var config = {}; //计算配置
                for (var i in this.defaultConfig) { //覆盖默认配置
                    if (typeof this.ftxConfig[i] != 'undefined') {
                        config[i] = this.ftxConfig[i];
                    } else {
                        config[i] = this.defaultConfig[i];
                    }
                }
                return config;
            },
            selectedAll(){ //全选数据项
                var res = [];
                for (var i in this.list.data) {
                    res[i] = this.list.data[i]['id'];
                }
                return res;
            },
            sizerConfig(){//过滤器配置
                return {
                    dataUrl: this.config.dataUrl, //筛选数据地址
                    exportUrl: this.config.exportUrl //数据导出url
                };
            },
            tableContentConfig(){ //数据表内容配置项
                return {
                    dataUrl: this.config.dataUrl, //排序数据地址
                    editUrl: this.config.editUrl, //编辑数据url
                    destroyUrl: this.config.destroyUrl, //排序数据地址
                    fields: this.config.fields, //显示字段
                    operation: this.config.operation, //是否显示操作列
                    primaryKey: this.config.primaryKey,
                    operationClass:this.config.operationClass //操作样式
                };
            },
            paginateConfig(){ //翻页配置项
                return {
                    dataUrl: this.config.dataUrl
                };
            }
        },
        methods: {
            //修改数据源
            updateData: function (datas) {
                this.selected = [];
                this.list = datas;
                this.callback(datas);
            },
            //修改参数项
            updateOption: function (key, value) {
                this.options[key] = value;
            },
            updateIds(ids){
                this.selected = ids;
            },
            //全选
            handleCheckAllChange(val){
                this.checkAll = val;
                if (!this.checkAll) {
                    this.selected = [];
                } else {
                    this.selected = this.selectedAll;
                }
            },
            //删除选中
            destroy(){
                if (this.selected.length) {
                    this.destroyIds(this.selected);
                }
            },
            cancelSelected(){
                this.selected = [];
            },
            //删除ID
            destroyIds(ids){
                var $this = this;
                $this.$store.commit('modal', {
                    'title': '提示',
                    'content': '您确定要删除吗?',
                    'callback':function(){
                        axios.post($this.config.destroyUrl, {ids: ids, json: 1}).then(function (response) {
                            $this.refresh(false);
                            $this.cancelSelected();
                        }).catch(function (error) {
                            this.$store.commit('alert', {
                                'showClose': true,
                                'title': '删除失败!',
                                'position': 'top',
                                'message': '',
                                'type': 'danger',
                                'iconClass': '',
                                'customClass': '',
                                'duration': 3000,
                                'show': true
                            });
                        });
                    }
                });
            },
            //刷新页面
            refresh(alert){
                if (this.loading) {
                    return false;
                }
                this.loading = true;
                var $this = this;
                axios.get(this.config.dataUrl, {params: this.options}).then(function (response) {
                    $this.selected = [];
                    $this.list = response.data;
                    $this.callback(response.data);
                    if (alert) {
                        $this.$store.commit('alert', {
                            'showClose': true,
                            'title': '刷新成功!',
                            'position': 'top',
                            'message': '',
                            'type': 'success',
                            'iconClass': '',
                            'customClass': '',
                            'duration': 3000,
                            'show': true
                        });
                    }
                    $this.loading = false;
                }).catch(function (error) {
                    $this.$store.commit('alert', {
                        'showClose': true,
                        'title': '刷新失败!',
                        'position': 'top',
                        'message': '',
                        'type': 'danger',
                        'iconClass': '',
                        'customClass': '',
                        'duration': 3000,
                        'show': true
                    });
                    $this.loading = false;
                })
            }
        }
    }
</script>

