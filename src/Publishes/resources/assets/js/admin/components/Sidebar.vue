<template>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img :src="app_logo" class="img-circle" alt="User Image" style="background: white">
                </div>
                <div class="pull-left info">
                    <p>{{user['name']}}</p>
                    <a href="#">
                        <i class="fa fa-circle text-success"></i> 在线
                    </a>
                </div>
            </div>
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <ul class="sidebar-menu" data-widget="tree" v-if="menus">
                <li is="sidebar-items" v-for="menu in menus" :ftx-data="menu" v-if="menu['status']==1"></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import SidebarItems from './SidebarItems.vue';
    export default {
        components: {
            "sidebar-items": SidebarItems
        },
        data(){
            return this.$store.state.global;
        }
    }
</script>
