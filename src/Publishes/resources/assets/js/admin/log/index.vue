<template>
    <section class="content">
        <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config">
            <template scope="props" slot="sizer-where">
                <div class="input-group input-group-sm" style="width:165px;">
                    <input class="form-control" v-model="props.where['menu.name']" placeholder="请输入关键字" type="text">
                </div>
            </template>
            <template scope="props" slot="table-content-header">
                <th v-for="(item,key) in props.fields" :class="item['class'] ? item['class']:''">
                    {{ item.name }}
                    <span v-if="item.order" class="glyphicon" @click="props.sorder(item.orderField ? item.orderField : key)" :class="{'glyphicon-sort':!props.order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':props.order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':props.order[item.orderField ? item.orderField : key]=='asc'}"></span>
                    </span>
                </th>
            </template>
            <template scope="props" slot="table-content-row">
                <td v-for="(value,key) in props.fields"  :class="value['class'] ? value['class']:''">
                    <span v-if="0"></span>
                    <span v-else-if="key =='parameters' || key =='return'">
                              {{ props.item | array_get(key) | str_limit(15)}}
                    </span>
                    <span v-else-if="key =='location'">
                              {{ props.item | array_get(key) || '未知'}}
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
                    "menu.name": {
                        "name": "操作名称",
                        "order": true,
                        "orderField":'menu_id'
                    },
                    "user.name": {"name": "用户", "order": true,"orderField":'user_id'},
                    "location": {"name": "位置", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    "ip": {"name": "IP地址", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    "parameters": {"name": "请求参数", "order": true},
                    "return": {"name": "返回数据", "order": true},
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