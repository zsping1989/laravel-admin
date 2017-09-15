<template>
    <section class="content">
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
                                    <div class="form-group" :class="{'has-error':props['error']['menu_id']}">
                                        <label>操作菜单</label>
                                             <span class="help-block">
                                                <i class="fa" :class="props['error']['menu_id']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['menu_id']">提示信息</span>
                                                <span v-for="error in props['error']['menu_id']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['menu']['name']" class="form-control"
                                               placeholder="请输入菜单ID">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user_id']}">
                                        <label>用户</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user_id']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user_id']">提示信息</span>
                                                <span v-for="error in props['error']['user_id']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['name']" class="form-control"
                                               placeholder="请输入用户ID">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['location']}">
                                        <label>位置</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['location']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['location']">提示信息</span>
                                                <span v-for="error in props['error']['location']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['location']" class="form-control"
                                               placeholder="请输入位置">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['ip']}">
                                        <label>IP地址</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['ip']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['ip']">提示信息</span>
                                                <span v-for="error in props['error']['ip']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['ip']" class="form-control"
                                               placeholder="请输入IP地址">

                                    </div>


                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['parameters']}">
                                        <label>请求参数</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['parameters']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['parameters']">提示信息</span>
                                                <span v-for="error in props['error']['parameters']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['parameters']" class="form-control" rows="11"
                                                  placeholder="请输入请求参数"></textarea>

                                    </div>
                                </div>
                               <div class="col-lg-4 col-md-6 col-sm-12">
                                   <div class="form-group" :class="{'has-error':props['error']['return']}">
                                       <label>返回数据</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['return']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['return']">提示信息</span>
                                                <span v-for="error in props['error']['return']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['return']" class="form-control" rows="11"
                                                  placeholder="请输入返回数据"></textarea>

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
        },
        data() {
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据提交地址
                backUrl: data.configUrl.indexUrl //数据列表页面
            };
            data.area_name = '未知';
            return data;
        },
        mounted() {

        }
    }
</script>