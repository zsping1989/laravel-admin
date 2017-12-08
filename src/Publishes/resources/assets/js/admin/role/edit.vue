<template>
    <section class="content">
        <link rel="stylesheet" href="/css/zTreeStyle/zTreeStyle.css" type="text/css">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <edit :ftx-data="row" :ftx-config="config">
                            <template scope="props">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['menus']}">
                                        <label>权限分配</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['menus']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['menus']">提示信息</span>
                                                <span v-for="error in props['error']['menus']">{{error}}</span>
                                            </span>
                                        <ztree v-model="props['row']['menus']" :id="'menus'" :chkbox-type='{"Y": "ps", "N": "s"}'  :data="maps['permissions']"></ztree>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['name']}">
                                        <label>名称</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['name']">提示信息</span>
                                                <span v-for="error in props['error']['name']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['name']" class="form-control"
                                               placeholder="请输入名称">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['description']}">
                                        <label>描述</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['description']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['description']">提示信息</span>
                                                <span v-for="error in props['error']['description']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['description']" class="form-control" rows="3"
                                                  placeholder="请输入描述"></textarea>

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['parent_id']}">
                                        <label>所属父级选择</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['parent_id']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['parent_id']">提示信息</span>
                                                <span v-for="error in props['error']['parent_id']">{{error}}</span>
                                            </span>
                                        <ztree v-model="props['row']['parent_id']"  :check-enable="false" :multiple="false" :id="'parent'" :chkbox-type='{ "Y" : "", "N" : "" }' :data="maps['optional_parents']"></ztree>
                                    </div>
                                </div>
                            </template>
                        </edit>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        components: {
            "ztree":function(resolve){
                require(['public/Ztree.vue'], resolve); //异步组件
            }
        },
        data:function() {
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据提交地址
                backUrl: data.configUrl.indexUrl //数据列表页面
            };
            return data;
        },
        mounted:function() {
        }
    }
</script>