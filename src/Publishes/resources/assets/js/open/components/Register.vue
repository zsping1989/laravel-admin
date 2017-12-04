<template>
    <div class="login-box-body">
        <div class="login-logo">
            <a href="/"><b>{{config['app_name']}}</b></a>
        </div>
            <form :action="config['dataUrl']" method="post">
                <div class="form-group has-feedback" :class="{'has-error':errors[config['usernameKey']]}">
                    <label class="control-label">
                        <span v-show="!errors[config['usernameKey']]">请填写6-18位的字母组合</span>
                        <i class="fa fa-times-circle-o" v-show="errors[config['usernameKey']]" ></i>
                        <span v-for="value in errors[config['usernameKey']]">
                           {{value}}
                        </span>
                    </label>
                    <input type="text" :name="config['usernameKey']" v-model="data[config['usernameKey']]" class="form-control"
                           placeholder="请填写用户名">
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors['password']}">
                    <label class="control-label">
                        <span v-show="!errors['password']">请填写相对复杂密码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['password']" ></i>
                     <span v-for="value in errors['password']">
                       {{value}}
                    </span>
                    </label>
                    <input type="password" name="password" v-model="data['password']" class="form-control" placeholder="请输入密码">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors['confirm_password']}">
                    <label class="control-label">
                        <span v-show="!errors['confirm_password']">确认密码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['confirm_password']" ></i>
                     <span v-for="value in errors['confirm_password']">
                       {{value}}
                    </span>
                    </label>
                    <input type="password" class="form-control"  v-model="data['confirm_password']" placeholder="重新输入密码">
                    <span class="fa fa-sign-in form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error': (errors['email']||errors['mobile_phone'])}">
                    <label class="control-label">
                        <span v-show="!(errors['mobile_phone'] || errors['email'])">激活方式</span>
                        <i class="fa fa-times-circle-o" v-show="(errors['mobile_phone'] || errors['email'])" ></i>
                        <span v-for="value in errors['mobile_phone']">
                            {{value}}
                        </span>
                        <span v-for="value in errors['email']">
                           {{value}}
                        </span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{config['communicationMode'][config['defaultActivate']]}}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li v-for="(communicationMode,key) in config['communicationMode']" @click="changeCommunicationMode(key)">
                                    <a>{{communicationMode}}</a>
                                </li>
                            </ul>
                        </div>
                        <input class="form-control" v-model="data[config['defaultActivate']]"  placeholder="请输入" type="text">
                        <span class="fa fa-envelope form-control-feedback"></span>
                    </div>

                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors['verify']}">
                    <label class="control-label">
                        <span v-show="!errors['verify']">请验证验证码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['verify']" ></i>
                           <span v-for="value in errors['verify']">
                           {{value}}
                        </span>
                    </label>
                    <geetest  v-if="config['verify']['type']=='geetest'" :url="config['verify']['dataUrl']" v-model="data['verify']" :data="config['verify']['data']"></geetest>
                    <captcha v-if="config['verify']['type']=='captcha'" :url="config['verify']['dataUrl']" v-model="data['verify']" :data="config['verify']['data']"></captcha>
                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors['mobile_phone_code']}" v-show="defaultConfig['defaultActivate']=='mobile_phone'">
                    <label class="control-label">
                        <span v-show="!errors['mobile_phone_code']">短信验证码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['mobile_phone_code']" ></i>
                     <span v-for="value in errors['mobile_phone_code']">
                       {{value}}
                    </span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button  @click="send" type="button" :disabled="sending" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              发送短信<span v-show="sending && time">({{time}}s)</span>
                            </button>
                        </div>
                        <input type="text" class="form-control"  v-model="data['mobile_phone_code']" placeholder="输入短信验证码">
                    </div>
                    <span class="fa fa-spinner form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors[config['agreeKey']]}">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" :name="config['agreeKey']" v-model="data[config['agreeKey']]">已阅读并同意 <a href="#">使用条款</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="button" @click="register" class="button-login btn btn-primary btn-block btn-flat">注册</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="social-auth-links text-center other-login" v-if="config['otherLogin'].length &&  !config['other']">
            <p>---------------- 其它方式登录 ----------------</p>
            <div class="row">
                <div class="col-xs-4" v-for="item in config['otherLogin']">
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
                <a :href="config['loginUrl']" v-if="config['loginUrl']" class="pull-right">已有用户</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Geetest from './Geetest.vue';
    import Captcha from './Captcha.vue';
    export default {
        components: {
            geetest:Geetest,
            captcha:Captcha
        },
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
                    usernameKey:'username', //用户名键
                    agreeKey:'agree', //同意协议键
                    defaultActivate:'email', //默认账号激活方式
                    otherLogin: [], //三方登录配置
                    other:'',
                    app_name:'LaravelAdmin', //应用名称
                    verify:{ //验证方式
                        type:'geetest', //极验
                        dataUrl:'', //验证方式为图片时为图片地址,为极验验证时为极验后台接口
                        data:{} //极验验证相关数据
                    },
                    communicationMode:{
                        'email':'电子邮箱',
                        'mobile_phone':'手机号'
                    },
                    loginUrl:'', //登录链接
                    forgetUrl:'', //忘记密码链接
                    dataUrl:'', //注册提交地址
                    sendUrl:'' //发送短信验证码地址
                },
                loading: false, //提交中
                sending:false, //短信发送中
                time:0,
                data:{
                    password:'', //密码
                    confirm_password:'', //确认密码
                    email:'', //电子邮箱
                    mobile_phone:'', //手机号
                    mobile_phone_code:'', //手机号验证码
                    verify:''
                },
                errors:{}
            };
            if(typeof this.ftxConfig.usernameKey=='undefined' && this.ftxConfig.usernameKey){
                data.data[this.ftxConfig.usernameKey] = '';
            }
            if(typeof this.ftxConfig.agreeKey=='undefined' && this.ftxConfig.agreeKey){
                data.data[this.ftxConfig.agreeKey] = false;
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
            //切换通讯方式
            changeCommunicationMode(key){
                for(var i in this.config['communicationMode']){
                    if(i==key){
                        this.defaultConfig['defaultActivate']=key;
                    }else {
                        this.data[i]='';
                    }
                }
            },
            //执行注册
            register(){
                if (this.loading) {
                    return false;
                }
                var $this = this;
                if (!this.data['verify'] && $this.defaultConfig.defaultActivate=='email') {
                    $this.errors = {'verify':['验证码验证失败']};
                    return false;
                }
                this.loading = true;
                var post_data = {};
                post_data['json'] = 1;
                post_data[this.config.usernameKey] = this.data[this.config.usernameKey] || ''; //用户名
                post_data[this.config.agreeKey] = this.data[this.config.agreeKey] || ''; //同意协议
                if($this.config['verify']['type']=='captcha'){
                    post_data['verify'] = $this.data['verify'];
                }else {
                    post_data['verify'] = $($this.$el).find("input[name='geetest_challenge']").val(); //验证码
                    post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                }
                post_data['model'] = $this.defaultConfig.defaultActivate; //激活方式
                post_data['password_confirmation']=this.data['confirm_password']; //确认密码
                post_data['password']=this.data['password'];
                post_data['email']=this.data['email'];
                post_data['mobile_phone']=this.data['mobile_phone'];
                post_data['mobile_phone_code']=this.data['mobile_phone_code'];
                post_data['other'] = $this.config.other;
                axios.post($this.config.dataUrl,post_data)
                        .then(function(res){
                            $this.loading = false;
                            if(res.data.redirect){
                                window.location.href = res.data.redirect;
                            }
                            $this.data['verify'] = '';
                        })
                        .catch(function(error){
                            $this.loading = false;
                            $this.errors = catchError(error);
                            $this.data['verify'] = '';
                        });
            },
            //发送短信验证码
            send(){
                var $this = this;
                if (this.sending) {
                    $this.errors = {'mobile_phone_code':['短信正在发送...']};
                    return false;
                }
                if (!this.data['verify']) {
                    $this.errors = {'verify':['验证码验证失败']};
                    return false;
                }
                //短信发送中
                $this.sending = true;
                var post_data = {};
                post_data['json'] = 1;
                if($this.config['verify']['type']=='captcha'){
                    post_data['verify'] = $this.data['verify'];
                }else {
                    post_data['verify'] = $($this.$el).find("input[name='geetest_challenge']").val();
                    post_data['geetest_validate'] = $($this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $($this.$el).find("input[name='geetest_seccode']").val();
                }
                post_data['mobile_phone'] = this.data['mobile_phone'];
                var t;

                axios.post($this.config.sendUrl,post_data)
                        .then(function(res){
                            //倒计时允许第二次发送验证码
                            var data = res.data;
                            $this.time = data.countdown;
                            t = setInterval(function(){
                                $this.time--;
                                if(!$this.time){
                                    $this.sending = false;
                                    clearInterval(t);
                                }
                            },1000);
                            $this.data['verify'] = '';
                            $this.errors = {};
                        })
                        .catch(function(error){
                            $this.sending = false;
                            $this.errors = catchError(error);
                            $this.data['verify'] = '';
                        });
            }
        },
        created(){

        }
    }
</script>
