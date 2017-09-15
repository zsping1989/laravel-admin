<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <form enctype="multipart/form-data" :action="row['url']" target="_blank" method="post">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>选择导入文件</label>
                                        <input name="_token" type="hidden" v-model="token">
                                        <input type="file" name="excel" placeholder="请选择文件">
                                    </div>
                                    <div class="form-group">
                                        <label>分类选择</label>
                                        <select class="form-control input-sm" v-model="row['selected']">
                                            <option v-for="(value,index) in maps['options']" :value="index">{{value['name']}}</option>
                                        </select>
                                        <label>导入类型选择</label>
                                        <select class="form-control input-sm" v-model="row['url']">
                                            <option value="">请选择</option>
                                            <option v-for="(value,index) in maps['options'][row['selected']]['values']" :value="value['url']">{{value['name']}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="box-footer">
                                        <div class="col-xs-6">
                                            <button type="submit" :disabled="row['url'] ? null : 'disabled'" class="btn btn-info pull-right">提交</button>
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="button" class="btn btn-default reset" @click="resetForm">重置</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        components: {
        },
        data() {
            var data = this.$store.state;
            data.old = this.copyObj(data.row);
            return data;
        },
        mounted() {

        },
        methods : {
            //重置表单
            resetForm() {
                this.error = {};
                this.row = this.copyObj(this.old);
            },
            copyObj: function (obj) {
                return JSON.parse(JSON.stringify(obj));
            }
        }
    }
</script>