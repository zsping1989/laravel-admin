<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">页面标题</h3>
                    </div>
                    <div class="box-body">
                        <edit :ftx-data="row" :ftx-config="config">
                            <template scope="props">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['uname']}">
                                        <label>用户名</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['uname']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['uname']">提示信息</span>
                                                <span v-for="error in props['error']['uname']">{{error}}</span>
                                         </span>
                                        <input type="text" v-model="props['row']['uname']" class="form-control"
                                               :disabled="props['row']['id']"
                                               placeholder="请输入用户名">
                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['password']}">
                                        <label>密码</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['password']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['password']">提示信息</span>
                                                <span v-for="error in props['error']['password']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['password']" class="form-control"
                                               placeholder="请输入密码">


                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['email']}">
                                        <label>电子邮箱</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['email']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['email']">提示信息</span>
                                                <span v-for="error in props['error']['email']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['email']" class="form-control"
                                               placeholder="请输入电子邮箱">

                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['name']}">
                                        <label>昵称</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['name']">提示信息</span>
                                                <span v-for="error in props['error']['name']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['name']" class="form-control"
                                               placeholder="请输入昵称">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['mobile_phone']}">
                                        <label>电话</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['mobile_phone']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['mobile_phone']">提示信息</span>
                                                <span v-for="error in props['error']['mobile_phone']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['mobile_phone']" class="form-control"
                                               placeholder="请输入电话">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['qq']}">
                                        <label>QQ号码</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['qq']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['qq']">提示信息</span>
                                                <span v-for="error in props['error']['qq']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['qq']" class="form-control"
                                               placeholder="请输入QQ号码">

                                    </div>


                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
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
                                    <div class="form-group" :class="{'has-error':props['error']['description']}">
                                        <label>备注</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['description']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['description']">提示信息</span>
                                                <span v-for="error in props['error']['description']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['description']" class="form-control" rows="4"
                                                  placeholder="请输入备注"></textarea>

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
            return data;
        },
        mounted() {

        }
    }
</script>