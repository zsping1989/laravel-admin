<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <edit :ftx-data="row" :ftx-config="config">
                            <template scope="props">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group" :class="{'has-error':props['error']['type']}">
                                        <label>类型</label>
                                             <span class="help-block">
                                                <i class="fa" :class="props['error']['type']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['type']">提示信息</span>
                                                <span v-for="error in props['error']['type']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="maps['type'][props['row']['type']]" class="form-control"
                                               placeholder="">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['data.title']}">
                                        <label>标题</label>
                                             <span class="help-block">
                                                <i class="fa" :class="props['error']['data.title']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['data.title']">提示信息</span>
                                                <span v-for="error in props['error']['data.title']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['data']['title']" class="form-control"
                                               placeholder="请输入标题">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['data.content']}">
                                        <label>内容</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['data.content']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['data.content']">提示信息</span>
                                                <span v-for="error in props['error']['data.content']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['data']['content']" class="form-control" rows="3"
                                                  placeholder="请输入内容"></textarea>

                                    </div>
                                </div>
                            </template>

                        </edit>
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
        data() {
            var data = this.$store.state;
            data.config = {
                dataUrl: data.configUrl.editUrl, //数据提交地址
                backUrl: data.configUrl.indexUrl //数据列表页面
            };
            return data;
        },
        mounted() {

        }
    }
</script>