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
                                    <div class="form-group" :class="{'has-error':props['error']['icons']}">
                                        <label>图标</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['icons']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['icons']">提示信息</span>
                                                <span v-for="error in props['error']['icons']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['icons']" class="form-control"
                                               placeholder="请输入图标">

                                    </div>

                                    <div class="form-group" :class="{'has-error':props['error']['url']}">
                                        <label>URL路径</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['url']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['url']">提示信息</span>
                                                <span v-for="error in props['error']['url']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['url']" class="form-control"
                                               placeholder="请输入URL路径">

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

                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['is_page']}">
                                        <label>是否为页面</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['is_page']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['is_page']">提示信息</span>
                                                <span v-for="error in props['error']['is_page']">{{error}}</span>
                                            </span>
                                        <div>
                                                    <span v-for="(item,index) in maps['is_page']">
                                                        <input type="radio" v-model="props['row']['is_page']"
                                                               :value="index"> {{item}}
                                                    </span>
                                        </div>

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['status']}">
                                        <label>状态</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['status']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['status']">提示信息</span>
                                                <span v-for="error in props['error']['status']">{{error}}</span>
                                            </span>
                                        <div>
                                                    <span v-for="(item,index) in maps['status']">
                                                        <input type="radio" v-model="props['row']['status']"
                                                               :value="index"> {{item}}
                                                    </span>
                                        </div>

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['method']}">
                                        <label>请求方式</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['method']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['method']">提示信息</span>
                                                <span v-for="error in props['error']['method']">{{error}}</span>
                                            </span>
                                        <div>
                                                    <span v-for="(item,index) in maps['method']">
                                                        <input type="checkbox" v-model="props['row']['method']"
                                                               :value="index"> {{item}}
                                                    </span>
                                        </div>

                                    </div>



                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['parent_id']}">
                                        <label>父级菜单</label>
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
                require(['public/Ztree.vue'], resolve);
            } //异步组件
        },
        data() {
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据提交地址
                backUrl: data.configUrl.indexUrl //数据列表页面
            };
            return data;
        },
        mounted(){

        }
    }
</script>