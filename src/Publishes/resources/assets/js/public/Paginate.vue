<template>
    <div class="main-pagination pull-right">
        共 {{total}} 条，{{pageSize}} 条/页
        <ul class="pagination pagination-sm no-margin ">
            <li :class="{ disabled: currentPage==1 }">
                <a :href="(currentPage-1) | trueUrl" aria-label="Previous" @click="toPage(currentPage-1)">
                    <span aria-hidden="true">{{config['prevText']}}</span>
                </a>
            </li>
            <li v-show="config['fringe'] && currentPage>config['pageLength']+1">
                <a :href="1 | trueUrl" @click="toPage(1)">1</a>
            </li>
            <li v-for="v in config['pageLength']" v-show="currentPage-config['pageLength']+v-1>0">
                <a :href="(currentPage-config['pageLength']+v-1) | trueUrl"
                   @click="toPage(currentPage-config['pageLength']+v-1)">{{currentPage-config['pageLength']+v-1}}</a>
            </li>
            <li class="active">
                <a href="#">{{currentPage}}</a>
            </li>
            <li v-for="v in config['pageLength']" v-show="currentPage+v<=lastPage">
                <a :href="(currentPage-config['pageLength']+v-1) | trueUrl" @click="toPage(currentPage+v)">{{currentPage+v}}</a>
            </li>
            <li v-show="config['fringe'] && currentPage+config['pageLength']<lastPage">
                <a :href="lastPage | trueUrl" @click="toPage(lastPage)">{{lastPage}}</a>
            </li>
            <li :class="{ disabled: currentPage==lastPage }">
                <a aria-label="Next" @click="toPage(currentPage+1)">
                    <span aria-hidden="true">{{config['nextText']}}</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            //分页配置
            ftxConfig: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            //翻页参数
            ftxParams: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            //数据源
            ftxData: {
                type: Object,
                default: function () {
                    //可以默认获取第一页数据
                    return {
                        total: 0,
                        per_page: 20,
                        current_page: 1,
                        data: []
                    };
                }
            }
        },

        data: function () {
            return {
                //默认配置
                defaultConfig: {
                    dataUrl: '', //数据请求地址
                    totalKey: 'total', //数据总条数
                    perPageKey: 'per_page', //每页数据条数
                    currentPageKey: 'current_page', //当前页码
                    pageParameter: 'page', //翻页参数
                    prevText: '«', //前一页显示
                    nextText: '»', //后一页显示
                    pageLength: 2, //页码长度
                    fringe: true, //首尾两端
                    ajax: true //ajax翻页
                },
                paging: false
            }
        },
        computed: {
            //当前配置
            config: function () {
                //计算配置
                var config = {};
                //覆盖默认配置
                for (var i in this.defaultConfig) {
                    if (typeof this.ftxConfig[i] != 'undefined' && this.ftxConfig[i]) {
                        config[i] = this.ftxConfig[i];
                    } else {
                        config[i] = this.defaultConfig[i];
                    }
                }
                //数据源地址
                if (typeof this.ftxData['next_page_url'] != 'undefined') {
                    config['dataUrl'] = config['dataUrl'] || this.ftxData['next_page_url'] || this.ftxData['prev_page_url'];
                }
                config['dataUrl'] = config['dataUrl'] || '';
                return config;
            },
            //最后一页
            lastPage: function () {
                if (this.ftxData[this.config['perPageKey']] > 0) {
                    var total = Number(this.ftxData[this.config['totalKey']]);
                    var per_page = Number(this.ftxData[this.config['perPageKey']]);
                    var last_page = Math.ceil(total / per_page);
                    return last_page ? last_page : 1;
                }
                return 1;
            },
            //当前页码
            currentPage: function () {
                var current_page = Number(this.ftxData[this.config['currentPageKey']]) || 1;
                current_page = current_page >= this.lastPage ? this.lastPage : current_page;
                current_page = current_page < 1 ? 1 : current_page;
                return current_page;
            },
            //总条数
            total(){
                return this.ftxData['total'] ? this.ftxData['total'] : 0;
            },
            //页码大小
            pageSize(){
                return Number(this.ftxData[this.config['perPageKey']]);
            }

        },
        methods: {
            handleCurrentChange(num){
                this.toPage(num);
            },
            //跳转到某一页
            toPage: function (page) {
                //需要翻页页码
                page = Math.floor(Number(page));
                //当前页码
                var current_page = Number(this.ftxData[this.config['currentPageKey']]) || 1;
                //翻页页码大于最大页码为最大页码
                page = page >= this.lastPage ? this.lastPage : page;
                //翻页页码小于最小页码为最小页码
                page = page < 1 ? 1 : page;
                //当前页码或非ajax或没有翻页路径或正在翻页无需执行翻页
                if (page == current_page || !this.config['ajax'] || !this.config['dataUrl'] || this.paging == page) {
                    return false;
                }
                //正在翻页标志,防止重复点击
                this.paging = page;
                var options = {params: this.ftxParams};
                options.params['page'] = page;
                var $this = this;
                //执行翻页
                axios.get(this.config['dataUrl'], options).then(function (response) {
                    //改变父组件数据源
                    $this.$emit('http-succeed', response.data);
                    $this.paging = false;
                }).catch(function (error) {
                    $this.paging = false;
                })
            }
        },
        filters: {
            //获取真实URL地址
            trueUrl: function (page) {
                return null;
            }
        }

    }
</script>

