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
                                    <div class="form-group" :class="{'has-error':props['error']['name']}">
                                        <label>名称</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['name']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['name']">提示信息</span>
                                                <span v-for="error in props['error']['name']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['name']" class="form-control"
                                               placeholder="请输入名称">

                                    </div>

                                    <div class="form-group" :class="{'has-error':props['error']['key']}">
                                        <label>键</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['key']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['key']">提示信息</span>
                                                <span v-for="error in props['error']['key']">{{error}}</span>
                                            </span>
                                        <input type="text" disabled="disabled" v-model="props['row']['key']" class="form-control"
                                               placeholder="请输入键">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['value']}">
                                        <label>值</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['value']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['value']">提示信息</span>
                                                <span v-for="error in props['error']['value']">{{error}}</span>
                                            </span>
                                        <input type="text" v-model="props['row']['value']" class="form-control"
                                               placeholder="请输入值">

                                    </div>
                                    <div class="form-group" :class="{'has-error':props['error']['description']}">
                                        <label>描述</label>
                                             <span class="help-block">
                                                <i class="fa"
                                                   :class="props['error']['description']?'fa-times-circle-o':'fa-info-circle'"></i>
                                                <span v-show="!props['error']['description']">提示信息</span>
                                                <span v-for="error in props['error']['description']">{{error}}</span>
                                            </span>
                                        <textarea v-model="props['row']['description']" class="form-control" rows="3"
                                                  placeholder="请输入描述"></textarea>

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