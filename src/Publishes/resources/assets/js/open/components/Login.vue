<template>
    <div class="login-box-body">
        <div class="login-logo">
            <a href="/"><b>{{config['app_name']}}</b></a>
        </div>
            <form :action="config['dataUrl']" method="post">
            <div class="form-group has-feedback"
                 :class="{'has-error':errors[config['usernameKey']] || errors['uname'] || errors['email'] || errors['qq'] || errors['mobile_phone']}">
                <label class="control-label">
                    <i class="fa fa-times-circle-o" v-show="errors[config['usernameKey']] || errors['uname'] || errors['email'] || errors['qq'] || errors['mobile_phone']" ></i>
                    <span v-for="value in errors[config['usernameKey']]">
                       {{value}}
                    </span>
                    <span v-for="value in errors['uname']">
                       {{value}}
                    </span>
                     <span v-for="value in errors['email']">
                       {{value}}
                    </span>
                     <span v-for="value in errors['qq']">
                       {{value}}
                    </span>
                     <span v-for="value in errors['mobile_phone']">
                       {{value}}
                    </span>
                </label>
                <input type="text"
                       :name="config['usernameKey']"
                       v-model="data[config['usernameKey']]"
                       class="form-control"
                       placeholder="请输入账号(电子邮箱、用户名、手机号)">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback" :class="{'has-error':errors['password']}">
                <label class="control-label">
                    <i class="fa fa-times-circle-o" v-show="errors['password']" ></i>
                     <span v-for="value in errors['password']">
                       {{value}}
                    </span>
                </label>
                <input type="password" name="password" v-model="data['password']" class="form-control" placeholder="请输入密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback" :class="{'has-error':errors['geetest_challenge']}">
                <label class="control-label">
                    <i class="fa fa-times-circle-o" v-show="errors['geetest_challenge']" ></i>
                       <span v-for="value in errors['geetest_challenge']">
                       {{value}}
                    </span>
                </label>
                <div id="geetest-captcha"></div>
                <p id="wait" v-show="loadGeetest">正在加载验证码...</p>
            </div>
            <div class="form-group has-feedback">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" :name="config['rememberKey']" v-model="data[config['rememberKey']]">记住登录
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="button" @click="login" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="social-auth-links text-center" v-if="config['otherLogin'].length">
            <p>---------------- 其它方式登录 ----------------</p>
            <div class="row">
                <div class="col-xs-2" v-for="item in config['otherLogin']">
                    <a :href="item['url']">
                        <div class="img-circle icon login-icon" :class="item['class']">
                            <i class="fa" :class="'fa-'+item['type']"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" v-if="config['forgetUrl'] || config['registerUrl']">
            <div class="col-lg-12">
                <a :href="config['forgetUrl']" v-if="config['forgetUrl']" class="pull-left">忘记密码</a>
                <a :href="config['registerUrl']" v-if="config['registerUrl']" class="pull-right">注册用户</a>
            </div>
        </div>
    </div>
</template>

<script>
    import geetest from './gt';
    export default {
        props: {
            //分页配置
            ftxConfig: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            //数据
            ftxData:{
                type: Object,
                default: function () {
                    return {};
                }
            }
        },
        data() {
            let data = {
                //默认配置
                defaultConfig: {
                    usernameKey:'username',
                    rememberKey:'remember',
                    //三方登录配置
                    otherLogin: [],
                    app_name:'LaravelAdmin',
                    verify:{
                        type:'geetest',
                        data:''
                    },
                    registerUrl:'', //注册链接
                    forgetUrl:'', //忘记密码链接
                    dataUrl:'' //登录提交地址
                },
                loadGeetest:true,
                loading: false, //提交中
                data:{
                    password:''
                },
                errors:{}
            };
            if(typeof this.ftxConfig.usernameKey=='undefined' && this.ftxConfig.usernameKey){
                data.data[this.ftxConfig.usernameKey] = '';
            }
            if(typeof this.ftxConfig.rememberKey=='undefined' && this.ftxConfig.rememberKey){
                data.data[this.ftxConfig.rememberKey] = false;
            }
            return data;
        },
        computed: {
            //当前配置
            config: function () {
                //计算配置
                var config = {};
                //覆盖默认配置
                for (var i in this.defaultConfig) {
                    if (typeof this.ftxConfig[i] != 'undefined') {
                        config[i] = this.ftxConfig[i];
                    } else {
                        config[i] = this.defaultConfig[i];
                    }
                }
                return config;
            }
        },
        methods: {
            login(){
                var $this = this;
                var validate = window.captchaObj.getValidate();
                if (!validate) {
                    $this.errors = {'geetest_challenge':['滑块验证失败']};
                    return false;
                }
                var post_data = {};
                post_data[this.config.usernameKey] = this.data[this.config.usernameKey];
                post_data[this.config.rememberKey] = this.data[this.config.rememberKey];
                post_data['password'] = this.data['password'];
                post_data['json'] = 1;
                post_data['geetest_challenge'] = $("input[name='geetest_challenge']").val();
                post_data['geetest_validate'] = $("input[name='geetest_validate']").val();
                post_data['geetest_seccode'] = $("input[name='geetest_seccode']").val();
                post_data['remember'] = this.data['remember'] ? 1 : undefined;
                axios.post($this.config.dataUrl,post_data)
                        .then(function(res){
                            if(res.data.redirect){
                                window.location.href = res.data.redirect;
                            }
                            captchaObj.refresh();
                        })
                        .catch(function(error){
                            var data = error.response.data;
                            var errors = {};
                            if(typeof data == "object"){
                                for(var i in data){
                                    errors[i] = [];
                                    if(typeof data[i]== "object"){
                                        for(var j in data[i]){
                                            errors[i][errors[i].length]= data[i][j].replace(i,'').replace(i.replace('_',' '),'');
                                        }
                                    }else {
                                        errors[i][errors[i].length]=data[i].replace(i,'').replace(i.replace('_',' '),'');
                                    }
                                }
                                $this.errors = errors;
                                captchaObj.refresh();
                            }else {
                                window.location.reload();
                            }
                        });
            }
        },
        created(){
            var $this = this;
            $(function(){
                initGeetest(window.datas.geetest, function(captchaObj){
                    window.captchaObj = captchaObj;
                    captchaObj.appendTo("#geetest-captcha");
                    captchaObj.onReady(function() {
                        $this.loadGeetest = false;
                    });
                });
                $('.el-icon-error1').attr('class','el-input__icon fa fa-user');
                $('.el-icon-error2').attr('class','el-input__icon fa fa-lock');
            });
        }
    }
</script>
