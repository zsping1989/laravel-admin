/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
/**
 * 组件引入
 */
require('../bootstrap');
window.Vue = require('vue');
require('../public/filters');
import DatePicker  from 'element-ui/lib/date-picker';
Vue.use(DatePicker);

import Vuex from 'vuex';
Vue.use(Vuex);
/*import iView from 'iview';
 Vue.use(iView);*/


/**
 * 数据准备
 */
let defaultConfig = {
    sidebarCollapse:false,
    alerts:[],
    modal:null,
    statusClass:[
        'default',
        'primary',
        'success',
        'info',
        'danger',
        'warning'
    ]
};
if(!(window.datas && typeof window.datas==='object' && window.datas.constructor != Array)){
    window.datas = {};
}
window.datas =_.merge(defaultConfig,datas);
const store = new Vuex.Store({
    state:datas ,
    mutations: {
        //顶部操作菜单切换
        toggleSidebar(state){
            state.sidebarCollapse = !state.sidebarCollapse;
        },
        //全局弹窗消息
        alert(state,alert){
            Vue.set(state.alerts,state.alerts.length,alert);
        },
        //全局对话框消息
        modal(state,modal){
            Vue.set(state,'modal',modal);
        }
    }
});



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//页面公共组件
import Header from './components/Header.vue';
import Breadcrumb from './components/Breadcrumb.vue';
import Footer from './components/Footer.vue';
import MainAlert from './components/Alert.vue';
import MainModal from './components/Modal.vue';
import DataTable from '../public/DataTable.vue';
import Edit from '../public/Edit.vue';

Vue.component("data-table",DataTable);
Vue.component("edit",Edit);
let components = {
    'main-header':Header, //顶部导航
    'breadcrumb':Breadcrumb, //面包屑导航
    'main-footer':Footer, //底部
    'main-alert':MainAlert, //弹窗
    'main-modal':MainModal,
    'index':function(resolve){
        require(['./index.vue'], resolve);
    },
    'error-404':function(resolve){
        require(['./error/404.vue'], resolve);
    },
    'notification-index':function(resolve){
        require(['./notification/index.vue'], resolve);
    },
    'notification-edit':function(resolve){
        require(['./notification/edit.vue'], resolve);
    },
    'personage-index':function(resolve){
        require(['./personage/index.vue'], resolve);
    },
    'personage-password':function(resolve){
        require(['./personage/password.vue'], resolve);
    }
};
//页面组件异步渲染
//components[window.datas.global.page] = (resolve) => require(['./'+window.datas.global.page_path+'.vue'], resolve);

const app = new Vue({
    el: '#app',
    store,
    components:components,
    data(){
        return this.$store.state;
    },
    mounted(){
        let $this = this;
        //添加弹窗拦截器
        window.axios.interceptors.response.use(function (response) {
            //弹窗
            if (typeof response.data != 'undefined' && typeof response.data.alert != 'undefined' && response.data.alert) {
                $this.$store.commit('alert',response.data.alert);
            }
            //跳转
            if (typeof response.data != 'undefined' && typeof response.data.redirect != 'undefined' && response.data.redirect) {
                window.location.href = response.data.redirect;
            }
            return response;
        }, function (error,a,b) {
            //弹窗
            if (typeof error.response.data != 'undefined' && typeof error.response.data.alert != 'undefined' && error.response.data.alert) {
               $this.$store.commit('alert',response.data.alert);
            }
            //跳转
            if (typeof error.response.data != 'undefined' && typeof error.response.data.redirect != 'undefined' && error.response.data.redirect) {
                window.location.href = error.response.data.redirect;
            }
            return Promise.reject(error);
        });
    }
});
