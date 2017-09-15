<template>
    <section class="content">
        <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config">
            <template scope="props" slot="sizer-where">
                <div class="input-group input-group-sm" style="width:200px;">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{maps['keywords'][props.where['key']]}}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li v-for="(value,index) in maps['keywords']" @click="props.where[props.where['key']]='';props.where['key']=index"><a href="#">{{value}}</a></li>
                        </ul>
                    </div>
                    <input class="form-control" v-model="props.where[props.where['key']]" placeholder="请输入关键字" type="text">
                </div>

            </template>
            <template scope="props" slot="table-content-header">
                <th v-for="(item,key) in props.fields" :class="item['class'] ? item['class']:''">
                    {{ item.name }}
                    <span v-if="item.order" class="glyphicon" @click="props.sorder(item.orderField ? item.orderField : key)" :class="{'glyphicon-sort':!props.order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':props.order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':props.order[item.orderField ? item.orderField : key]=='asc'}"></span>
                </th>
            </template>
            <template scope="props" slot="table-content-row">
                <td v-for="(value,key) in props.fields" :class="value['class'] ? value['class']:''">
                    <span v-if="0"></span>
                    <span v-else-if="key =='user.status'">
                        <span class="label" :class="'label-'+statusClass[props.item['user']['status']%statusClass.length]">{{ maps['user']['status'][props.item['user']['status']] }}</span>
                    </span>
                    <span v-else-if="key.indexOf('.')!=-1">
                        {{ props.item | array_get(key) }}
                    </span>
                    <span v-else>
                        {{ props.item[key] }}
                    </span>
                </td>
            </template>
        </data-table>
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
                    "user_id": {"name": "用户ID", "order": true},
                    "user.uname": {"name": "用户名", "order": false},
                    "user.name": {"name": "昵称", "order": false,'class':'hidden-xs'},
                    "user.email": {"name": "电子邮箱", "order": false,'class':'hidden-xs'},
                    "user.mobile_phone": {"name": "电话", "order": false,'class':'hidden-xs visible-md visible-lg'},
                    "user.status": {"name": "状态", "order": false},
                    "created_at": {"name": "创建时间", "order": true,'class':'visible-lg'},
                    "updated_at": {"name": "修改时间", "order": true,'class':'visible-lg visible-md'}
                },
                operation: true //需要操作列
            };
            return data;
        },
        mounted() {

        },
        methods: {
            //修改数据源
            updateData: function (datas) {
                this.lists = datas;
            }
        }
    }
</script>