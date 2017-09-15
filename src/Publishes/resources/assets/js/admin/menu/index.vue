<template>
    <section class="content">
        <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config">
            <template scope="props" slot="sizer-where">
                <select class="form-control input-sm" v-model="props.where['method']">
                    <option value="">请求方式</option>
                    <option v-for="(value,index) in maps['method']" :value="index">{{value}}</option>
                </select>
                <select class="form-control input-sm" v-model="props.where['is_page']">
                    <option value="">是否为页面</option>
                    <option v-for="(value,index) in maps['is_page']" :value="index">{{value}}</option>
                </select>
                <select class="form-control input-sm" v-model="props.where['status']">
                    <option value="">状态</option>
                    <option v-for="(value,index) in maps['status']" :value="index">{{value}}</option>
                </select>
                <div class="input-group input-group-sm" style="width:165px;">
                    <input class="form-control" v-model="props.where['name']" placeholder="请输入关键字" type="text">
                </div>
            </template>
            <template scope="props" slot="table-content-header">
                <th v-for="(item,key) in props.fields" :class="item['class'] ? item['class']:''">
                    {{ item.name }}
                    <span v-if="item.order" class="glyphicon" @click="props.sorder(item.orderField ? item.orderField : key)" :class="{'glyphicon-sort':!props.order[item.orderField ? item.orderField : key],'glyphicon-sort-by-attributes-alt':props.order[item.orderField ? item.orderField : key]=='desc','glyphicon-sort-by-attributes':props.order[item.orderField ? item.orderField : key]=='asc'}"></span>
                </th>
            </template>
            <template scope="props" slot="table-content-row">
                <td v-for="(value,key) in props.fields"  :class="value['class'] ? value['class']:''">
                    <span v-if="0"></span>
                        <span v-else-if="key=='name'">
                       {{ props.item['level'] | deep}} {{ props.item | array_get(key)}}
                    </span>
                    <span v-else-if="key =='method'">
                         <span class="label" v-for="value in props.item[key]" :class="value | checkbox_class(2,statusClass)" style="margin-left: 5px;">
                                    {{ maps[key][value] }}
                                </span>
                    </span>
                     <span v-else-if="key =='is_page'">
                                <span class="label" :class="'label-'+statusClass[props.item[key]%statusClass.length]">{{ maps[key][props.item[key]] }}</span>
                     </span>
                     <span v-else-if="key =='icons'">
                         <i class="fa" :class="props.item[key]"></i>
                     </span>
                    <span v-else-if="key =='status'">
                                <span class="label" :class="'label-'+statusClass[props.item[key]%statusClass.length]">{{ maps[key][props.item[key]] }}</span>
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
                    "id": {"name": "ID", "order": true},
                    "icons": {"name": "图标", "order": true},
                    "name": {"name": "名称", "order": true},
                    "url": {"name": "URL路径", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    //"parent_id": {"name": "父级ID", "order": true},
                    "method": {"name": "请求方式", "order": true},
                    "is_page": {"name": "是否为页面", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    "status": {"name": "状态", "order": true},
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