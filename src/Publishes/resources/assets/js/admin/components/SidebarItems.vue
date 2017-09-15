<template>
    <li class="treeview" :class="{'active':active,'menu-open':open}">
        <a :href="url ? url : null" @click="toggle">
            <i class="fa" :class="icons"></i>
            <span>{{name}}</span>
            <span class="pull-right-container" v-if="childrens">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu" v-if="childrens" :class="{'show':open,'hide':!open}">
            <li is="sidebar-items" v-for="children in childrens" :ftx-data="children" v-if="children['status']==1"></li>
        </ul>
    </li>
</template>

<script>
    export default {
        name:'sidebar-items',
        props: {
            ftxData: {
                type: Object,
                default: function () {
                    return {};
                }
            }
        },
        data(){
            if(typeof this.ftxData.childrens == 'undefined'){
                this.ftxData.childrens = null;
            }
            return this.ftxData;
        },
        methods: {
            toggle: function() {
                this.open = !this.open;
            }
        }
    }
</script>
