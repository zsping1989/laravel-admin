<template>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <a href="#" class="btn btn-primary btn-block margin-bottom">类型选择</a>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li :class="{'active':!options['where']['type']}">
                                <a href="./index">
                                    <i class="fa fa-inbox"></i> 全部
                                    <span class="label label-primary pull-right" v-show="list['no_read_count']['total']">{{list['no_read_count']['total']}}</span>
                                </a>
                            </li>
                            <li :class="{'active':options['where']['type']=='App\\Notifications\\Message'}">
                                <a href="./index?where[type]=App\Notifications\Message">
                                    <i class="fa fa-envelope-o"></i>消息通知
                                    <span class="label label-info pull-right" v-show="list['no_read_count']['data']['App\\Notifications\\Message']">
                                        {{list['no_read_count']['data']['App\\Notifications\\Message']}}
                                    </span>
                                </a>
                            </li>
                            <li :class="{'active':options['where']['type']=='App\\Notifications\\Notification'}">
                                <a href="./index?where[type]=App\Notifications\Notification">
                                <i class="fa fa-bell-o"></i> 提醒消息
                                    <span class="label label-warning pull-right" v-show="list['no_read_count']['data']['App\\Notifications\\Notification']">
                                        {{list['no_read_count']['data']['App\\Notifications\\Notification']}}
                                    </span>
                                </a>
                            </li>
                            <li  :class="{'active':options['where']['type']=='App\\Notifications\\Task'}">
                                <a href="./index?where[type]=App\Notifications\Task">
                                    <i class="fa fa-flag-o"></i> 任务提醒
                                    <span class="label pull-right bg-red" v-show="list['no_read_count']['data']['App\\Notifications\\Task']">
                                        {{list['no_read_count']['data']['App\\Notifications\\Task']}}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config" :callback="updateData">
                    <template scope="props" slot="sizer-where">
                        <select class="form-control input-sm" v-model="props.where['read_at']">
                            <option value="">状态</option>
                            <option v-for="(value,index) in maps['read_at']" :value="index">{{value}}</option>
                        </select>
                        <div class="input-group input-group-sm" style="width:165px;">
                            <input class="form-control" v-model="props.where['data']" placeholder="请输入关键字" type="text">
                        </div>
                    </template>
                    <template scope="props" slot="table-content-header">
                        <th v-for="(item,key) in props.fields" :class="item['class'] ? item['class']:''">
                            {{ item.name }}
                    <span v-if="item.order" class="glyphicon"
                          @click="props.sorder(item.orderField ? item.orderField : key)"
                          :class="{'glyphicon-sort':!props.order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':props.order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':props.order[item.orderField ? item.orderField : key]=='asc'}">
                    </span>
                        </th>
                    </template>
                    <template scope="props" slot="table-content-row">
                        <td v-for="(value,key) in props.fields" :class="value['class'] ? value['class']:''">
                            <span v-if="0"></span>
                                   <span v-else-if="key =='type'">
                                       <span class="label label-primary" v-if="props.item[key]=='App\\Notifications\\Message'">
                                           {{ maps[key][props.item[key]] }}
                                       </span>
                                        <span class="label label-success" v-if="props.item[key]=='App\\Notifications\\Notification'">
                                           {{ maps[key][props.item[key]] }}
                                       </span>
                                        <span class="label label-info" v-if="props.item[key]=='App\\Notifications\\Task'">
                                           {{ maps[key][props.item[key]] }}
                                       </span>
                                   </span>
                       <span v-else-if="key =='data.content'">
                              {{ props.item | array_get(key) | str_limit(15)}}
                    </span>
                               <span v-else-if="key =='read_at'">
                        <span class="label label-default" v-if="props.item['read_at']">已读</span>
                                   <span class="label label-primary" v-if="!props.item['read_at']">未读</span>
                    </span>
                            <span v-else-if="key.indexOf('.')!=-1">
                        {{ props.item | array_get(key) }}
                    </span>
                    <span v-else>
                        {{ props.item[key] }}
                    </span>
                        </td>
                    </template>
                    <template scope="props" slot="table-content-operation">
                        <button v-if="props.config.destroyUrl" @click="props.destroyId(props.item['id'])" title="删除选中" type="button" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <a title="编辑" class="btn btn-info btn-xs" v-if="props.config.editUrl" :href="props.config.editUrl+'/'+props.item['id']" target="_blank">
                            <i class="fa fa-edit"></i>
                        </a>
                    </template>
                </data-table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</template>

<script>
    export default {
        components: {
        },
        data(){
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.listUrl, //数据获取地址
                editUrl: data.configUrl.showUrl, //数据编辑页面
                destroyUrl: data.configUrl.destroyUrl, //删除数据地址
                exportUrl: data.configUrl.exportUrl,
                fields: {
                    //"id": {"name": "ID", "order": true},

                    "data.title": {"name": "标题", "order": false, 'class': 'hidden-xs visible-md visible-lg'},
                    "data.content": {"name": "内容", "order": false, 'class': 'hidden-xs visible-md visible-lg'},
                    "type": {
                        "name": "类型",
                        "order": true
                    },
                    "read_at": {"name": "状态", "order": true},
                    "diff_time":{'name':'时间距离','order':false},
                    //"created_at": {"name": "创建时间", "order": true, 'class': 'visible-lg'},
                    "updated_at": {"name": "修改时间", "order": true, 'class': 'visible-lg visible-md'}
                },
                operation: true, //需要操作列
                add:false
            };
            return data;
        },
        mounted() {

        },
        methods: {
            //修改数据源
            updateData: function (datas) {
                this.list = datas;
            }
        }
    }
</script>
