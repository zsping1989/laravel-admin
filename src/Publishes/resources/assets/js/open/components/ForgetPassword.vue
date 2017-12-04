<template>
    <div class="login-box-body">
        <div class="login-logo">
            <a href="/"><b>{{config['app_name']}}</b></a>
        </div>
            <form :action="config['dataUrl']" method="post">
                <div class="form-group has-feedback" :class="{'has-error':errors[config['usernameKey']]}">
                    <label class="control-label">
                        <span v-show="!errors[config['usernameKey']]">用户名</span>
                        <i class="fa fa-times-circle-o" v-show="errors[config['usernameKey']]" ></i>
                        <span v-for="value in errors[config['usernameKey']]">
                           {{value}}
                        </span>
                    </label>
                    <input type="text"
                           :name="config['usernameKey']"
                           v-model="data[config['usernameKey']]"
                           class="form-control"
                           placeholder="请输入用户名">
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error': (errors['email']||errors['mobile_phone'])}">
                    <label class="control-label">
                        <span v-show="!(errors['mobile_phone'] || errors['email'])">找回方式</span>
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
                <div class="form-group has-feedback" :class="{'has-error':errors['email_code']}" v-show="defaultConfig['defaultActivate']=='email'">
                    <label class="control-label">
                        <span v-show="!errors['email_code']">点击发送邮箱校验码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['email_code']" ></i>
                     <span v-for="value in errors['email_code']">
                       {{value}}
                    </span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button  @click="send('email')" type="button" :disabled="sending" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                发送邮件<span v-show="sending && time">({{time}}s)</span>
                            </button>
                        </div>
                        <input type="text" class="form-control"  v-model="data['email_code']" placeholder="输入邮箱验证码">
                    </div>
                    <span class="fa fa-spinner form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" :class="{'has-error':errors['mobile_phone_code']}" v-show="defaultConfig['defaultActivate']=='mobile_phone'">
                    <label class="control-label">
                        <span v-show="!errors['mobile_phone_code']">点击发送短信校验码</span>
                        <i class="fa fa-times-circle-o" v-show="errors['mobile_phone_code']" ></i>
                     <span v-for="value in errors['mobile_phone_code']">
                       {{value}}
                    </span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button  @click="send('sms')" type="button" :disabled="sending" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                发送短信<span v-show="sending && time">({{time}}s)</span>
                            </button>
                        </div>
                        <input type="text" class="form-control"  v-model="data['mobile_phone_code']" placeholder="输入短信验证码">
                    </div>
                    <span class="fa fa-spinner form-control-feedback"></span>
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
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-xs-8">
                        </div>
                        <div class="col-xs-4">
                            <button @click="reset" type="button" class="button-login btn btn-primary btn-block btn-flat">提交</button>
                        </div>
                    </div>
                </div>

            </form>
        <div class="social-auth-links text-center other-login" v-if="config['otherLogin'].length && !config['other']">
            <p>---------------- 其它方式登录 ----------------</p>
            <div class="row">
                <div :class="'col-xs-'+other_col" v-for="item in config['otherLogin']">
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
                <a :href="config['loginUrl']" v-if="config['loginUrl']" class="pull-left">直接登录</a>
                <a :href="config['registerUrl']" v-if="config['registerUrl']" class="pull-right">注册用户</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Geetest from './Geetest.vue';
    import Captcha from './Captcha.vue';
    export default {
        components: {
            geetest:Geetest, //滑块验证组件
            captcha:Captcha //验证码验证组件
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
                    usernameKey:'username',
                    otherLogin: [], //三方登录配置
                    app_name:'LaravelAdmin',
                    defaultActivate:'email', //默认账号激活方式
                    verify:{
                        type:'geetest',
                        dataUrl:'',
                        data:{}
                    },
                    communicationMode:{
                        'email':'电子邮箱',
                        'mobile_phone':'手机号'
                    },
                    registerUrl:'', //注册链接
                    loginUrl:'', //直接登录链接
                    dataUrl:'', //登录提交地址
                    sendSmsUrl:'', //发送短信验证码地址
                    sendEmailUrl:'' //发送邮件验证码地址
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
                    email_code:'', //邮箱验证码
                    verify:''
                },
                errors:{},
                t:''
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
            },
            other_col(){
                var count = this.config['otherLogin'].length;
                var other_col = Math.ceil(12/count);
                return other_col<2?2:other_col;
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
            reset(){
                if(this.loading){
                    return false;
                }
                var $this = this;
                var type = this.defaultConfig['defaultActivate'];
                if (!this.data[type+'_code']) {
                    $this.errors = {};
                    $this.errors[type+'_code'] = ['请填写校验码'];
                    return false;
                }
                $this.loading= true;
                var post_data = {};
                post_data[this.config.usernameKey] = this.data[this.config.usernameKey] || '';
                post_data['model'] = type; //找回方式
                post_data['password_confirmation']=this.data['confirm_password']; //确认密码
                post_data['password']=this.data['password'];
                post_data[type+'_code']=this.data[type+'_code'];
                if($this.config['verify']['type']=='captcha'){
                    post_data['verify'] = $this.data['verify'];
                }else {
                    post_data['verify'] = $(this.$el).find("input[name='geetest_challenge']").val();
                    post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                }
                axios.post($this.config.dataUrl,post_data)
                        .then(function(res){
                            $this.loading= false;
                            if(res.data.redirect){
                                window.location.href = res.data.redirect;
                            }
                            $this.data['verify'] = '';
                        })
                        .catch(function(error){
                            $this.loading= false;
                            $this.errors = catchError(error);
                            $this.data['verify'] = '';
                        });
            },
            //发送短信验证码
            send(type){
                if (this.sending) {
                    this.errors = {'email_code':['验证码正在发送...']};
                    return false;
                }
                var $this = this;
                if (!this.data['verify']) {
                    $this.errors = {'verify':['验证码验证失败']};
                    return false;
                }
                //短信发送中
                this.sending = true;
                var post_data = {};
                post_data[this.config.usernameKey] = this.data[this.config.usernameKey] || '';
                if(type=='email'){
                    var url = $this.config.sendEmailUrl;
                    post_data['email'] = this.data['email'] || '';
                }else {
                    var url = $this.config.sendSmsUrl;
                    post_data['mobile_phone'] = this.data['mobile_phone'] || '';
                }

                if($this.config['verify']['type']=='captcha'){
                    post_data['verify'] = $this.data['verify'];
                }else {
                    post_data['verify'] = $(this.$el).find("input[name='geetest_challenge']").val();
                    post_data['geetest_validate'] = $(this.$el).find("input[name='geetest_validate']").val();
                    post_data['geetest_seccode'] = $(this.$el).find("input[name='geetest_seccode']").val();
                }
                axios.post(url,post_data)
                        .then(function(res){
                            //倒计时允许第二次发送验证码
                            var data = res.data;
                            $this.time = data.countdown;
                            $this.t = setInterval(function(){
                                $this.time--;
                                if(!$this.time){
                                    $this.sending = false;
                                    clearInterval($this.t);
                                }
                            },1000);
                            $this.data['verify'] = '';
                            $this.errors = {};
                            $this.data['verify'] = '';
                        })
                        .catch(function(error){
                            //短信发送中
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
