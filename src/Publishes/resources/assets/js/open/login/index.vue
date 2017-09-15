<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <login :ftx-config="loginConfig"></login>
        </div>
    </div>
</template>

<script>
    //组件
    import Login from '../components/Login.vue';
    export default {
        components: {
            'login': Login
        },
        data(){
            return {
                //登录配置
                loginConfig: {
                    usernameKey:'username',
                    rememberKey:'remember',
                    //三方登录配置
                    otherLogin: [
             /*           {type:'qq',url:'',"class":'hover-primary'},
                        {type:'wechat',url:'',"class":'hover-warning'},
                        {type:'weibo',url:'',"class":'hover-danger'},
                        {type:'github',url:'',"class":'hover-info'},
                        {type:'windows',url:'',"class":'hover-success'},
                        {type:'google',url:'',"class":'hover-primary'}*/
                    ],
                    app_name:this.$store.state.global.app_name,
                    verify:{
                        type:'geetest',
                        data:this.$store.state.geetest
                    },
                    registerUrl:'', //注册链接
                    forgetUrl:'', //忘记密码链接
                    dataUrl:'/open/login' //登录提交地址
                }
            }
        }
    }
</script>
