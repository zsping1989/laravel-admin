<template>
    <section class="content">
        <data-table :ftx-params="options" :ftx-data="list" :ftx-config="config">
            <template scope="props" slot="sizer-where">
                <el-date-picker
                        style="width: 110px"
                        :editable="false"
                        v-model="props.where['created_at'][0]"
                        size="small"
                        :format="'yyyy-MM-dd 23:59:59'"
                        @change="props.changeDate(props.where['created_at'],0,arguments[0])"
                        placeholder="日期开始">
                </el-date-picker>
                <el-date-picker
                        style="width: 110px"
                        :editable="false"
                        v-model="props.where['created_at'][1]"
                        size="small"
                        :format="'yyyy-MM-dd 23:59:59'"
                        @change="props.changeDate(props.where['created_at'],1,arguments[0])"
                        placeholder="日期结束">
                </el-date-picker>
                <select class="form-control input-sm" v-model="props.where['status']">
                    <option value="">状态</option>
                    <option v-for="(value,index) in maps['status']" :value="index">{{value}}</option>
                </select>
                <div class="input-group input-group-sm" style="width:165px;">
                    <input class="form-control" v-model="props.where['name|uname|mobile_phone|email']" placeholder="请输入关键字" type="text">
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
                    "uname": {"name": "用户名", "order": true},
                    "name": {"name": "昵称", "order": true,'class':'hidden-xs'},
                    "email": {"name": "电子邮箱", "order": true,'class':'hidden-xs'},
                    "mobile_phone": {"name": "电话", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    //"qq": {"name": "QQ号码", "order": true,'class':'hidden-xs visible-md visible-lg'},
                    "status": {"name": "状态", "order": true},
                    //"created_at": {"name": "创建时间", "order": true,'class':'visible-lg'},
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