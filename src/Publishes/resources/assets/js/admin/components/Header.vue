<template>
    <header class="main-header">
        <a href="/admin/index" class="logo">
            <span class="logo-mini"><b>{{app_name_initial}}</b></span>
            <span class="logo-lg"><b>{{app_name}}</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a class="sidebar-toggle" data-toggle="push-menu" @click="sidebarToggle" role="button" >
                <span class="sr-only">切换左侧菜单</span>
            </a>
            <div class="navbar-custom-menu pull-left" v-if="menus_module">
                <ul class="nav navbar-nav">
                    <li :class="{'active':menu['active']}" v-for="menu in menus_module">
                        <a :href="menu['active'] ? '#':menu['url']">
                            <i class="fa" :class="menu['icons']"></i>
                            {{menu['name']}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu" v-if="news['messages']">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success"  v-show="news['messages']['total']">{{news['messages']['total']}}</span>
                        </a>
                        <ul class="dropdown-menu" v-if="news['messages']['total']">
                            <li class="header">你有{{news['messages']['total']}}条消息</li>
                            <li>
                                <ul class="menu">
                                    <li v-for="item in news['messages']['data']">
                                        <a :href="'/'+module+item['data']['url']+'/'+item['id']">
                                            <div class="pull-left">
                                                <img src="/css/img/user2-160x160.jpg" class="img-circle" alt="用户头像">
                                            </div>
                                            <h4>
                                                {{item['data']['title']}}
                                                <small><i class="fa fa-clock-o"></i> {{item['diff_time']}}</small>
                                            </h4>
                                            <p>{{item['data']['content']}}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="/admin/notification/index?where[type]=App\Notifications\Message">查看所有</a></li>
                        </ul>
                    </li>
                    <li class="dropdown notifications-menu"  v-if="news['notifications']">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning" v-show="news['notifications']['total']">{{news['notifications']['total']}}</span>
                        </a>
                        <ul class="dropdown-menu" v-if="news['notifications']['total']">
                            <li class="header">你有{{news['notifications']['total']}}条通知</li>
                            <li >
                                <ul class="menu">
                                    <li v-for="item in news['notifications']['data']">
                                        <a :href="'/'+module+item['data']['url']+'/'+item['id']">
                                            <i class="fa" :class="item['data']['class']"></i>
                                            {{item['data']['content']}}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="/admin/notification/index?where[type]=App\Notifications\Notification">查看所有</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu"  v-if="news['tasks']">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger"  v-show="news['tasks']['total']">{{news['tasks']['total']}}</span>
                        </a>
                        <ul class="dropdown-menu" v-show="news['tasks']['total']">
                            <li class="header">你有{{news['tasks']['total']}}个任务</li>
                            <li>
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Create a nice theme
                                                <small class="pull-right">40%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Some task I need to do
                                                <small class="pull-right">60%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Make beautiful transitions
                                                <small class="pull-right">80%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="/admin/notification/index?where[type]=App\Notifications\Task">查看所有</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img :src="app_logo" class="user-image" alt="用户头像" style="background: white">
                            <span class="hidden-xs">{{user['name']}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- 用户头像 -->
                            <li class="user-header">
                                <img :src="app_logo" class="img-circle" alt="用户头像" style="background: white">
                                <p style="font-size: 15px">
                                    {{user['name']}} - {{user['role_name']}}
                                    <small>入职时间 ：{{user['created_at'] | str_limit(10,'')}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">项目栏位</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">项目栏位</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">项目栏位</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/admin/personage/index" class="btn btn-default btn-flat">个人中心</a>
                                </div>
                                <div class="pull-right">
                                    <form method="post" action="/open/logout">
                                        <input type="hidden" name="_token" :value="token">
                                        <button type="submit" class="btn btn-default btn-flat">退出</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a @click="controlSidebarToggle"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        data(){
            return this.$store.state.global;
        },
        methods:{
            sidebarToggle(){
                this.$store.commit('toggleSidebar');
            },
            controlSidebarToggle(){
                this.$store.commit('controlSidebar');
            }
        }
    }
</script>
