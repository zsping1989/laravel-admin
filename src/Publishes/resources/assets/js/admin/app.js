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
import UserIndex from './user/Index.vue';
import UserEdit from './user/Edit.vue';
import Index from './Index.vue';
import RoleIndex from './role/Index.vue';
import RoleEdit from './role/Edit.vue';
import LogIndex from './log/Index.vue';
import LogEdit from './log/Edit.vue';
import MenuIndex from './menu/Index.vue';
import MenuEdit from './menu/Edit.vue';
import ConfigIndex from './config/Index.vue';
import ConfigEdit from './config/Edit.vue';
import YearIndex from './year/Index.vue';
import YearEdit from './year/Edit.vue';
import GradeIndex from './grade/Index.vue';
import GradeEdit from './grade/Edit.vue';
import BankIndex from './bank/Index.vue';
import BankEdit from './bank/Edit.vue';
import TeamIndex from './team/Index.vue';
import TeamEdit from './team/Edit.vue';
import FirmIndex from './firm/Index.vue';
import FirmEdit from './firm/Edit.vue';
import MemberIndex from './member/Index.vue';
import MemberBill from './member/Bill.vue';
import MemberEdit from './member/Edit.vue';
import ProductIndex from './product/Index.vue';
import ProductEdit from './product/Edit.vue';
import ClassifyIndex from './classify/Index.vue';
import ClassifyEdit from './classify/Edit.vue';
import ToleadIndex from './tolead/Index.vue';
import PersonageIndex from '../home/personage/Index.vue';
import PersonagePassword from '../home/personage/Password.vue';
import NotificationIndex from '../home/notification/Index.vue';
import NotificationEdit from '../home/notification/Edit.vue';
import AdminIndex from './admin/Index.vue';
import AdminEdit from './admin/Edit.vue';
import RateIndex from './rate/Index.vue';
import RateEdit from './rate/Edit.vue';
import ProductYearIndex from './product_year/Index.vue';
import ProductYearEdit from './product_year/Edit.vue';
import OrderIndex from './order/Index.vue';
import OrderEdit from './order/Edit.vue';
import OrderProductIndex from './order_product/Index.vue';
import OrderProductEdit from './order_product/Edit.vue';
import PayIndex from './pay/Index.vue';
import PayEdit from './pay/Edit.vue';
import BillIndex from './bill/Index.vue';
import BillEdit from './bill/Edit.vue';*/

Vue.component("data-table",DataTable);
Vue.component("edit",Edit);
let components = {
    'main-header':Header, //顶部导航
    'breadcrumb':Breadcrumb, //面包屑导航
    'control-sidebar':ControlSidebar, //右侧工具设置
    'main-footer':Footer, //底部
    'main-sidebar':Sidebar,
    'main-alert':MainAlert, //弹窗
    'main-modal':MainModal

   /* ,
    'user-index':UserIndex,
    'user-edit':UserEdit,
    'index':Index,
    'role-index':RoleIndex,
    'role-edit':RoleEdit,
    'log-index':LogIndex,
    'log-edit':LogEdit,
    'config-index':ConfigIndex,
    'config-edit':ConfigEdit,
    'year-index':YearIndex,
    'year-edit':YearEdit,
    'bank-index':BankIndex,
    'bank-edit':BankEdit,
    'grade-index':GradeIndex,
    'grade-edit':GradeEdit,
    'team-index':TeamIndex,
    'team-edit':TeamEdit,
    'classify-index':ClassifyIndex,
    'classify-edit':ClassifyEdit,
    'firm-index':FirmIndex,
    'firm-edit':FirmEdit,
    'member-index':MemberIndex,
    'member-bill':MemberBill,
    'member-edit': MemberEdit,
    'product-index':ProductIndex,
    'product-edit': ProductEdit,
    'tolead-index':ToleadIndex,
    'personage-index':PersonageIndex,
    'personage-password':PersonagePassword,
    'notification-index':NotificationIndex,
    'notification-edit':NotificationEdit,
    'menu-index':MenuIndex,
    'menu-edit':MenuEdit,
    'rate-index':RateIndex,
    'rate-edit':RateEdit,
    'product_year-index':ProductYearIndex,
    'product_year-edit':ProductYearEdit,
    'order-index':OrderIndex,
    'order-edit':OrderEdit,
    'order_product-index':OrderProductIndex,
    'order_product-edit':OrderProductEdit,
    'pay-index':PayIndex,
    'pay-edit':PayEdit,
    'bill-index':BillIndex,
    'bill-edit':BillEdit,
    'admin-index':AdminIndex,
    'admin-edit':AdminEdit*/
};



//页面组件异步渲染
components[window.datas.global.page] = (resolve) => require(['./'+window.datas.global.page_path+'.vue'], resolve);
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
