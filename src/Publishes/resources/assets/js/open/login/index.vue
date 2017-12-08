<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#register" data-toggle="tab">注册用户</a></li>
                    <li><a href="#forget-password" data-toggle="tab">找回密码</a></li>
                    <li class="pull-left active"><a href="#login" data-toggle="tab">{{other ? '绑定用户' : '登录用户'}}</a></li>
                </ul>
                <div class="tab-content no-padding">
                    <div class="chart tab-pane active" id="login" >
                        <login :ftx-config="loginConfig"></login>
                    </div>
                    <div class="chart tab-pane " id="register" >
                        <register :ftx-config="registerConfig"></register>
                    </div>
                    <div class="chart tab-pane " id="forget-password" >
                        <forget-password :ftx-config="forgetConfig"></forget-password>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Login from '../components/Login.vue'; //登录组件
    import Register from '../components/Register.vue'; //注册组件
    import ForgetPassword from '../components/ForgetPassword.vue'; //找回密码组件
    export default {
        components: {
            'login': Login,
            'register':Register,
            'forget-password':ForgetPassword
        },
        data(){
            return {
                //登录配置
                loginConfig: {
                    usernameKey:'username', //登录用户名的键
                    rememberKey:'remember', //记住登录的键
                    otherLogin: this.$store.state.other_login,//三方登录配置
                    other:this.$store.state.other,//三方登录绑定账号标记
                    app_name:this.$store.state.global.app_name, //APP名称
                    verify:this.$store.state.verify, //验证配置
                    mustVerify:this.$store.state.must_verify, //必须验证验证码
                    registerUrl:'', //注册链接
                    forgetUrl:'', //忘记密码链接
                    dataUrl:'/open/login' //登录提交地址
                },
                //注册用户配置
                registerConfig: {
                    usernameKey:'uname',
                    agreeKey:'agree',
                    otherLogin: this.$store.state.other_login,
                    other:this.$store.state.other,
                    app_name:this.$store.state.global.app_name,
                    verify:this.$store.state.verify,
                    communicationMode:this.$store.state.communication_mode['register'],//通讯方式
                    loginUrl:'', //登录链接
                    forgetUrl:'', //忘记密码链接
                    sendUrl:'/open/register/send-sms', //获取手机短信验证码地址
                    dataUrl:'/open/register' //注册提交地址
                },
                //找回密码配置
                forgetConfig:{
                    usernameKey:'uname',
                    otherLogin: this.$store.state.other_login,
                    app_name:this.$store.state.global.app_name,
                    verify:this.$store.state.verify,
                    communicationMode:this.$store.state.communication_mode['forgot_password'],//通讯方式
                    registerUrl:'', //注册链接
                    loginUrl:'', //登录链接
                    sendSmsUrl:'/open/forgot-password/send-sms', //获取手机短信验证码地址
                    sendEmailUrl:'/open/forgot-password/send-email',
                    dataUrl:'/open/forgot-password/reset-password' //忘记密码提交地址
                },
                other:this.$store.state.other //三方登录绑定账号标记
            }
        }
    }
</script>
