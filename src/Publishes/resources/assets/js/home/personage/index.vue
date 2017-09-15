<template>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" :src="global['app_logo']"
                             alt="公司标志LOGO">
                        <h3 class="profile-username text-center">{{global['user']['name']}}</h3>
                        <p class="text-muted text-center">{{global['user']['role_name']}}</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>订单总数</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>团队人数</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>佣金总额</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>
                        <a :href="'/'+global['module']+'/index'" class="btn btn-primary btn-block"><b>主页</b></a>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">关于我</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong>
                            <i class="fa fa-star margin-r-5"></i>
                            星级：
                            <i class="fa fa-star-o text-red" v-if="about['stars']==0"></i>
                            <i class="fa fa-star text-red" v-for="i in stars"></i>
                            <i class="fa fa-star-half-o text-red" v-if="half_stars"></i>
                        </strong>
                        <p>
                            {{maps['member']['stars'][about['stars']]}}
                        </p>
                        <hr>
                        <div>
                        <strong>
                            <i class="fa fa-user-plus margin-r-5"></i>
                            当前职级：
                            <span class="label label-success">{{about['grade']['name']}}</span>
                        </strong>
                        <p class="text-muted">{{about['grade']['description']}}</p>
                        </div>
                        <hr>
                        <div v-if="about['team']">
                        <strong>
                            <i class="fa fa-users margin-r-5"></i>
                            所属团队：
                            <span class="label label-primary">{{about['team']['name']}}</span>
                        </strong>
                        <p class="text-muted">
                            {{about['team']['description']}}
                        </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">资料修改</a></li>
                        <li><a href="#timeline" data-toggle="tab">职业发展</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <edit :ftx-data="row" :ftx-config="config">
                                <template scope="props">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group" :class="{'has-error':props['error']['name']}">
                                            <label>代理人</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['name']">提示信息</span>
                                                    <span v-for="error in props['error']['name']">{{error}}</span>
                                             </span>
                                            <input type="text" disabled="disabled" v-model="props['row']['name']"
                                                   class="form-control" placeholder="请输入代理人名称">
                                        </div>
                                        <div class="form-group" :class="{'has-error':props['error']['email']}">
                                            <label>电子邮箱</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['email']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['email']">提示信息</span>
                                                    <span v-for="error in props['error']['email']">{{error}}</span>
                                             </span>
                                            <input type="text" v-model="props['row']['email']" class="form-control"
                                                   placeholder="请输入电子邮箱">
                                        </div>
                                        <div class="form-group" :class="{'has-error':props['error']['mobile_phone']}">
                                            <label>手机号</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['mobile_phone']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['mobile_phone']">提示信息</span>
                                                    <span v-for="error in props['error']['mobile_phone']">{{error}}</span>
                                             </span>
                                            <input type="text" v-model="props['row']['mobile_phone']"
                                                   class="form-control" placeholder="请输入手机号">
                                        </div>
                                        <div v-if="is_member" class="form-group"
                                             :class="{'has-error':props['error']['member.bank_id']}">
                                            <label>开户行</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['member.bank_id']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['member.bank_id']">提示信息</span>
                                                    <span v-for="error in props['error']['member.bank_id']">{{error}}</span>
                                             </span>
                                            <select class="form-control input-sm"
                                                    v-model="props['row']['member']['bank_id']">
                                                <option :value="0">请选择开户银行</option>
                                                <option v-for="(value,index) in maps['member']['banks']" :value="index">
                                                    {{value}}
                                                </option>
                                            </select>
                                        </div>
                                        <div v-if="is_member" class="form-group"
                                             :class="{'has-error':props['error']['member.card_name']}">
                                            <label>开户名</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['member.card_name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['member.card_name']">提示信息</span>
                                                    <span v-for="error in props['error']['member.card_name']">{{error}}</span>
                                             </span>
                                            <select class="form-control input-sm"
                                                    v-model="props['row']['member']['card_name']">
                                                <option value="">请选择银行卡户名</option>
                                                <option v-for="(value,index) in maps['member']['card_names']"
                                                        :value="value">{{value}}
                                                </option>
                                            </select>
                                        </div>
                                        <div v-if="is_member" class="form-group"
                                             :class="{'has-error':props['error']['member.card']}">
                                            <label>结佣卡号</label>
                                            <span class="help-block">
                                                    <i class="fa"
                                                       :class="props['error']['member.card']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                    <span v-show="!props['error']['member.card']">提示信息</span>
                                                    <span v-for="error in props['error']['member.card']">{{error}}</span>
                                             </span>
                                            <input type="text" v-model="props['row']['member']['card']"
                                                   class="form-control" placeholder="请银行卡卡号">
                                        </div>
                                        <div v-if="is_member" class="form-group"
                                             :class="{'has-error':props['error']['member.bank_addr']}">
                                            <label>开户网点</label>
                                        <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['member.bank_addr']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['member.bank_addr']">提示信息</span>
                                                <span v-for="error in props['error']['member.bank_addr']">{{error}}</span>
                                         </span>
                                            <input type="text" v-model="props['row']['member']['bank_addr']"
                                                   class="form-control" placeholder="请填写开户网点">
                                        </div>
                                    </div>
                                </template>
                                <template scope="props" slot="footer">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="box-footer">
                                            <div class="col-xs-6">
                                                <button type="button" :disabled="config['dataUrl'] ? null : 'disabled'"
                                                        @click="props.submit" class="btn btn-info pull-right">提交
                                                </button>
                                            </div>
                                            <div class="col-xs-6">
                                                <button type="button" class="btn btn-default" @click="props.reset">重置
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </edit>
                        </div>
                        <div class="tab-pane" id="timeline">
                            <ul class="timeline timeline-inverse">
                                <li class="time-label">
                                    <span class="bg-red">
                                      2016-03-25
                                    </span>
                                </li>
                                <li>
                                    <i class="fa fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                                        <h3 class="timeline-header"><a href="#">加入公司</a> 初级代理人</h3>
                                        <div class="timeline-body">
                                            初级代理人
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="time-label">
                                    <span class="bg-green">
                                      2016-03-25
                                    </span>
                                </li>
                                <li>
                                    <i class="fa fa-user bg-aqua"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border"><a href="#">职级升级</a> 中级代理人
                                        </h3>
                                    </div>
                                </li>
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
    export default {
        components: {
        },
        data(){
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据获取地址
                backUrl: data.configUrl.backUrl //数据编辑页面
            };
            return data;
        },
        computed: {
            stars(){
                return Math.floor(this.about['stars']/2);
            },
            half_stars(){
                return this.about['stars']%2;
            }

        },
        mounted() {

        }
    }
</script>
