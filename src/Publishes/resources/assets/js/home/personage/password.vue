<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <edit :ftx-data="row" :ftx-config="config">
                            <template scope="props">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['old_password']}">
                                        <label>旧密码</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['old_password']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['old_password']">提示信息</span>
                                                <span v-for="error in props['error']['old_password']">{{error}}</span>
                                         </span>
                                        <input type="password" v-model="props['row']['old_password']"
                                               class="form-control" placeholder="请输入旧密码">
                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['password']}">
                                        <label>新密码</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['password']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['password']">提示信息</span>
                                                <span v-for="error in props['error']['password']">{{error}}</span>
                                         </span>
                                        <input type="password" v-model="props['row']['password']" class="form-control"
                                               placeholder="请输入新密码">
                                    </div>
                                    <div class="form-group"
                                         :class="{'has-error':props['error']['password_confirmation']}">
                                        <label>确认新密码</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['password_confirmation']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['password_confirmation']">提示信息</span>
                                                <span v-for="error in props['error']['password_confirmation']">{{error}}</span>
                                         </span>
                                        <input type="password" v-model="props['row']['password_confirmation']"
                                               class="form-control" placeholder="请确认新密码">
                                    </div>
                                </div>
                            </template>
                            <template scope="props" slot="footer">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="box-footer">
                                        <div class="col-xs-6">
                                            <button type="button" :disabled="config['dataUrl'] ? null : 'disabled'"  @click="props.submit" class="btn btn-info pull-right">提交</button>
                                        </div>
                                        <div class="col-xs-6">
                                            <button type="button" class="btn btn-default" @click="props.reset">重置</button>
                                        </div>
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
        data(){
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据获取地址
                backUrl: data.configUrl.backUrl //数据编辑页面
            };
            return data;
        },
        mounted() {

        }
    }
</script>
