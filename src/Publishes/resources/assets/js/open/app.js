/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

/**
 * 数据准备
 */
if(!(window.datas && typeof window.datas==='object' && window.datas.constructor != Array)){
    window.datas = {};
}
window.Vue = require('vue');
import Vuex from 'vuex';
Vue.use(Vuex);

/*import VueValidator from 'vue-validator';
Vue.use(VueValidator);*/

const store = new Vuex.Store({
    state:datas ,
    mutations: {

    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import DataTable from '../public/DataTable.vue';
import Edit from '../public/Edit.vue';
Vue.component("data-table",DataTable);
Vue.component("edit",Edit);

//页面
import LoginIndex from './login/index.vue';


const app = new Vue({
    el: '#app',
    store,
    components:{
        'login':LoginIndex
    },
    data(){
        return this.$store.state;
    }
});
