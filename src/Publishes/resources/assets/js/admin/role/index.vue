<template>
    <section class="content">
        <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config">
            <template scope="props" slot="sizer-where">
                <div class="input-group input-group-sm" style="width:165px;">
                    <input class="form-control" v-model="props.where['name']" placeholder="请输入关键字" type="text">
                </div>
            </template>
            <template scope="props" slot="table-content-header">
                <th v-for="(item,key) in props.fields"  :class="item['class'] ? item['class']:''">
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
                      <span v-else-if="key =='admins_count'">
                        <a :href="'/admin/admin/index?where[roles.id]='+props.item['id']">{{ props.item[key] }}</a>
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
                    "name": {"name": "名称", "order": true},
                    "description": {"name": "权限适用", "order": true},
                    "parent.name": {"name": "父级名称", "order": true,orderField:'parent_id'},
                    "admins_count": {"name": "管理员数量", "order": true},
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