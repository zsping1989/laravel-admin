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

                                    <!--  <div class="form-group" :class="{'has-error':props['error']['user_id']}">
                                          <label>用户ID</label>
                                               <span class="help-block">
                                                  <i class="fa" :class="props['error']['user_id']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                  <span v-show="!props['error']['user_id']">提示信息</span>
                                                  <span v-for="error in props['error']['user_id']">{{error}}</span>
                                              </span>
                                          <input type="text" v-model="props['row']['user_id']" class="form-control" placeholder="请输入用户ID">
                                      </div>-->
                                    <div class="form-group" :class="{'has-error':props['error']['user.uname']}">
                                        <label>用户名</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.uname']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.uname']">提示信息</span>
                                                <span v-for="error in props['error']['user.uname']">{{error}}</span>
                                         </span>
                                        <input type="text" v-model="props['row']['user']['uname']" class="form-control"
                                               placeholder="请输入用户名">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.password']}">
                                        <label>密码</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.password']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.password']">提示信息</span>
                                                <span v-for="error in props['error']['user.password']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['password']"
                                               class="form-control"
                                               placeholder="请输入密码">


                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.email']}">
                                        <label>电子邮箱</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.email']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.email']">提示信息</span>
                                                <span v-for="error in props['error']['user.email']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['email']" class="form-control"
                                               placeholder="请输入电子邮箱">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.name']}">
                                        <label>昵称</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.name']">提示信息</span>
                                                <span v-for="error in props['error']['user.name']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['name']" class="form-control"
                                               placeholder="请输入昵称">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.mobile_phone']}">
                                        <label>电话</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.mobile_phone']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.mobile_phone']">提示信息</span>
                                                <span v-for="error in props['error']['user.mobile_phone']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['mobile_phone']"
                                               class="form-control"
                                               placeholder="请输入电话">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.qq']}">
                                        <label>QQ号码</label>
                                         <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.qq']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.qq']">提示信息</span>
                                                <span v-for="error in props['error']['user.qq']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['user']['qq']" class="form-control"
                                               placeholder="请输入QQ号码">

                                    </div>


                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['user.status']}">
                                        <label>状态</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.status']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.status']">提示信息</span>
                                                <span v-for="error in props['error']['user.status']">{{error}}</span>
                                            </span>
                                        <div>
                                                    <span v-for="(item,index) in maps['user']['status']">
                                                        <input type="radio" v-model="props['row']['user']['status']"
                                                               :value="index"> {{item}}
                                                    </span>
                                        </div>

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['user.description']}">
                                        <label>备注</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.description']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.description']">提示信息</span>
                                                <span v-for="error in props['error']['user.description']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['user']['description']" class="form-control"
                                                  rows="4"
                                                  placeholder="请输入备注"></textarea>

                                    </div>


                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['user.roles']}">
                                        <label>用户角色选择</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['user.roles']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['user.roles']">提示信息</span>
                                                <span v-for="error in props['error']['user.roles']">{{error}}</span>
                                            </span>
                                        <ztree v-model="props['row']['roles']" :id="'roles'" :chkbox-type='{"Y": "", "N": "s"}' :data="maps['roles']"></ztree>
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
            "ztree":function(resolve){ //异步组件
                require(['public/Ztree.vue'], resolve);
            }
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