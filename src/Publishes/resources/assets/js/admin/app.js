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
    controlSidebar:false,
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
        //左边操作菜单切换
        toggleSidebar(state){
            state.sidebarCollapse = !state.sidebarCollapse;
        },
        //右边操作设置菜单切换
        controlSidebar(state){
            state.controlSidebar = !state.controlSidebar;
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
import ControlSidebar from './components/ControlSidebar.vue';
import Footer from './components/Footer.vue';
import Sidebar from './components/Sidebar.vue';
import MainAlert from '../home/components/Alert.vue';
import MainModal from '../home/components/Modal.vue';
import DataTable from '../public/DataTable.vue';
import Edit from '../public/Edit.vue';

/*//页面组件
 import UserIndex from './user/index.vue';
 import UserEdit from './user/edit.vue';
 import Index from './index.vue';
 import RoleIndex from './role/index.vue';
 import RoleEdit from './role/edit.vue';
 import LogIndex from './log/index.vue';
 import LogEdit from './log/edit.vue';
 import MenuIndex from './menu/index.vue';
 import MenuEdit from './menu/edit.vue';
 import ConfigIndex from './config/index.vue';
 import ConfigEdit from './config/edit.vue';
 import ToleadIndex from './tolead/index.vue';
 import PersonageIndex from '../home/personage/index.vue';
 import PersonagePassword from '../home/personage/password.vue';
 import NotificationIndex from '../home/notification/index.vue';
 import NotificationEdit from '../home/notification/edit.vue';
 import AdminIndex from './admin/index.vue';
 import AdminEdit from './admin/edit.vue';
import AreaIndex from './area/index.vue';
import AreaEdit from './area/edit.vue';*/

Vue.component("data-table",DataTable);
Vue.component("edit",Edit);
let components = {
    'main-header':Header, //顶部导航
    'breadcrumb':Breadcrumb, //面包屑导航
    'control-sidebar':ControlSidebar, //右侧工具设置
    'main-footer':Footer, //底部
    'main-sidebar':Sidebar,
    'main-alert':MainAlert, //弹窗
    'main-modal':MainModal,
    'index':function(resolve){
        require(['./index.vue'], resolve);
    },
    'user-index':function(resolve){
        require(['./user/index.vue'], resolve);
    },
    'user-edit':function(resolve){
        require(['./user/edit.vue'], resolve);
    },
    'role-index':function(resolve){
        require(['./role/index.vue'], resolve);
    },
    'role-edit':function(resolve){
        require(['./role/edit.vue'], resolve);
    },
    'log-index':function(resolve){
        require(['./log/index.vue'], resolve);
    },
    'log-edit':function(resolve){
        require(['./log/edit.vue'], resolve);
    },
    'config-index':function(resolve){
        require(['./config/index.vue'], resolve);
    },
    'config-edit':function(resolve){
        require(['./config/edit.vue'], resolve);
    },
    'tolead-index':function(resolve){
        require(['./tolead/index.vue'], resolve);
    },
    'personage-index':function(resolve){
        require(['./personage/index.vue'], resolve);
    },
    'personage-password':function(resolve){
        require(['./personage/password.vue'], resolve);
    },
    'notification-index':function(resolve){
        require(['./notification/index.vue'], resolve);
    },
    'notification-edit':function(resolve){
        require(['./notification/edit.vue'], resolve);
    },
    'menu-index':function(resolve){
        require(['./menu/index.vue'], resolve);
    },
    'menu-edit':function(resolve){
        require(['./menu/edit.vue'], resolve);
    },
    'admin-index':function(resolve){
        require(['./admin/index.vue'], resolve);
    },
    'admin-edit':function(resolve){
        require(['./admin/edit.vue'], resolve);
    },
    'area-index':function(resolve){
        require(['./area/index.vue'], resolve);
    },
    'area-edit':function(resolve){
        require(['./area/edit.vue'], resolve);
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
