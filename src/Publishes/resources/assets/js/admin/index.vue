<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><a :href="'/admin/order-product/index?where[recycle_at][0]='+start_day+'where[recycle_at][1]='+start_day">{{count['day_scale_premium']}}</a><sub style="font-size: 20px;">（元）</sub></h3>
                        <p>今日业绩</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <a href="/admin/order-product/index" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><a :href="'/admin/order-product/index?where[month_at][0]='+start_month+'&where[month_at][1]='+start_month+'&where[status][0]=1&where[status][1]=2&where[status][2]=6'">{{count['month_scale_premium']}}</a><sub style="font-size: 20px;">（元）</sub></h3>
                        <p>本月业绩</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <a href="/admin/order-product/index" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <a :href="'/admin/order-product/index?where[month_at][0]='+start_month+'&where[month_at][1]='+start_month+'&where[product.type]=1&where[status][0]=1&where[status][1]=2&where[status][2]=6'">
                                {{count['order']['total']}}
                            </a>
                            <sub style="font-size: 20px;">（件）</sub>
                        </h3>
                        <p>
                            本月保单（
                            <span v-for="item in count['order']['data']">
                                {{maps['order_product']['status'][item['status']]}}：
                                <a :href="'/admin/order-product/index?where[month_at][0]='+start_month+'&where[month_at][1]='+start_month+'&where[product.type]=1&where[status][0]='+item['status']">{{item['value']}}</a> 件
                            </span>
                            ）
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="/admin/order-product/index" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><a href="/admin/member/index?where[status]=3&where[id]=1">{{count['member']}}</a><sub style="font-size: 20px;">（人）</sub></h3>
                        <p>有效代理人员</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="/admin/member/index" class="small-box-footer">查看更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#grades-chart" data-toggle="tab">职级占比</a></li>
                        <li><a href="#stars-chart" data-toggle="tab">星级占比</a></li>
                        <li><a href="#sales-chart" data-toggle="tab">搜索树图</a></li>
                        <li><a href="#member-tree" data-toggle="tab">组织架构图</a></li>
                        <li class="pull-left header">
                            <a href="/admin/member/index" style="display: inline">
                                <i class="fa fa-inbox"></i>
                                我的团队
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content no-padding">
                        <echart :option="gradeOption" class="chart tab-pane active" id="grades-chart" style="position: relative; height: 500px;overflow: auto"></echart>
                        <echart :option="starsOption" :delay="300" class="chart tab-pane" id="stars-chart" style="position: relative; height: 500px;overflow: auto"></echart>
                        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 500px;overflow: auto">
                            <div class="box-header with-border">
                                <h3 class="box-title">快速搜索</h3>
                                <div class="box-tools pull-right" data-toggle="tooltip">
                                    <input type="text" v-model="filterText" class="form-control" @change="changeFilterText" placeholder="输入关键字搜索">
                                </div>
                            </div>
                            <div class="box-body">
                                <el-tree :data="members"
                                         empty-text="没有团队"
                                         :filter-node-method="filterNode"
                                         :render-content="renderContent"
                                         ref="tree"
                                         :props="defaultProps">
                                </el-tree>
                            </div>
                        </div>
                        <echart :option="memberOption" :delay="1500" class="chart tab-pane" id="member-tree" style="position: relative; height: 500px;overflow: auto"></echart>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Tree from 'element-ui/lib/tree';
    export default {
        components: {
            "el-tree":function (resolve, reject) {
                setTimeout(function () {
                    resolve(Tree);
                }, 1500)
            },
            "echart":(resolve) => require(['../public/Echart.vue'], resolve) //异步组件
        },
        data(){
            var data = this.$store.state;
            data.defaultProps = {
                children: 'children',
                label: 'user.names'
            };
            data.filterText = '';
            data.pieOption = {
                title : {
                    text: '',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:[]
                },
                toolbox: {
                    show : true,
                    feature : {
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 0
                                }
                            }
                        }
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'',
                        type:'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[]
                    }
                ]
            };
            return data;
        },
        methods: {
            changeFilterText() {
                this.$refs.tree.filter(this.filterText);
            },
            renderContent: function (createElement, { node, data, store }) {
                return createElement('span', {
                    domProps: {
                        innerHTML: data['name'] || '未知'
                    },
                    attrs: {
                        title: '连带责任人:' + (data['rname'] || '未知') + ' 所属团队:' + (data['team_name'] || '未知')
                    }
                })
            },
            filterNode(value, data) {
                if (!value) return true;
                var str = '';
                if (data['rname']) {
                    str += data['rname'];
                }
                if (data['team_name']) {
                    str += data['team_name'];
                }
                if (data['name']) {
                    str += data['name'];
                }
                return str.indexOf(value) !== -1;
            },
            getPieOption(data){
                var option = this.copyObj(this.pieOption);
                option.toolbox.feature.magicType.option.funnel.max = data.max;
                option.series[0].data = data.series;
                option.legend.data = data.legend;
                return option;
            },
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            }
        },
        computed:{
            gradeOption(){
                return this.getPieOption(this.grades);
            },
            starsOption(){
                return this.getPieOption(this.stars);
            },
            memberOption(){
                return {
                    title : {
                        text: ''
                    },
                    toolbox: {
                        show : true,
                        feature : {
                            saveAsImage : {show: true}
                        }
                    },
                    series : [
                        {
                            name:'树图',
                            type:'tree',
                            orient: 'vertical',  // vertical horizontal
                            rootLocation: {x: 'center', y: 50},
                            nodePadding: 40,
                            layerPadding: 200,
                            hoverable: false,
                            roam: true,
                            symbolSize: 6,
                            itemStyle: {
                                normal: {
                                    color: '#4883b4',
                                    label: {
                                        show: true,
                                        position: 'bottom',
                                        formatter: "{b}",
                                        textStyle: {
                                            color: '#000',
                                            fontSize: 5
                                        }
                                    },
                                    lineStyle: {
                                        color: '#ccc',
                                        type: 'curve' // 'curve'|'broken'|'solid'|'dotted'|'dashed'

                                    }
                                },
                                emphasis: {
                                    color: '#4883b4',
                                    label: {
                                        show: false
                                    },
                                    borderWidth: 0
                                }
                            },
                            data: this.members
                        }
                    ]
                };
            }
        },
        mounted(){
        }
    }
</script>
