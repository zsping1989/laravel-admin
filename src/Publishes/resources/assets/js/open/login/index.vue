<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#sales-chart" data-toggle="tab">注册用户</a></li>
                    <li class="pull-left active"><a href="#revenue-chart" data-toggle="tab">{{other ? '绑定用户' : '登录用户'}}</a></li>
                </ul>
                <div class="tab-content no-padding">
                    <div class="chart tab-pane active" id="revenue-chart" >
                        <login :ftx-config="loginConfig"></login>
                    </div>
                    <div class="chart tab-pane " id="sales-chart" >
                        <register :ftx-config="registerConfig"></register>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //组件
    import Login from '../components/Login.vue';
    import Register from '../components/Register.vue';
    export default {
        components: {
            'login': Login,
            'register':Register
        },
        data(){
            return {
                //登录配置
                loginConfig: {
                    usernameKey:'username',
                    rememberKey:'remember',
                    //三方登录配置
                    otherLogin: this.$store.state.other_login,
                    other:this.$store.state.other,
                    app_name:this.$store.state.global.app_name,
                    verify:{
                        type:'geetest',
                        dataUrl:this.$store.state.geetest.geetestUrl,
                        data:this.$store.state.geetest
                    },
                    registerUrl:'', //注册链接
                    forgetUrl:'', //忘记密码链接
                    dataUrl:'/open/login' //登录提交地址
                },
                registerConfig: {
                    usernameKey:'uname',
                    agreeKey:'agree',
                    otherLogin: this.$store.state.other_login,
                    other:this.$store.state.other,
                    app_name:this.$store.state.global.app_name,
                    verify:{
                        type:'geetest',
                        dataUrl:this.$store.state.geetest.geetestUrl,
                        data:this.$store.state.geetest
                    },
                    loginUrl:'', //登录链接
                    forgetUrl:'', //忘记密码链接
                    sendUrl:'/open/register/send-sms', //获取手机短信验证码地址
                    dataUrl:'/open/register' //注册提交地址
                },
                other:this.$store.state.other
            }
        }
    }
</script>
