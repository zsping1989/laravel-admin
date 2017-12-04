<template>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quick Example</h3>
                    </div>
                    <div class="box-body">
                        <edit :ftx-data="row" :ftx-config="config">
                            <template scope="props">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div :class="{'has-error':props['error']['name']}" class="form-group">
                                        <label>名称</label>
                                             <span class="help-block">
                                                <i :class="props['error']['name']?'fa-times-circle-o':'fa-info-circle'"
                                                   class="fa"></i>
                                                <span v-show="!props['error']['name']">提示信息</span>
                                                <span v-for="error in props['error']['name']">{{error}}</span>
                                            </span>
                                        <input v-model="props['row']['name']" placeholder="请输入名称" class="form-control"
                                               type="text" :disabled="!props.config['dataUrl']">

                                    </div>

                                    <div :class="{'has-error':props['error']['parent_id']}" class="form-group">
                                        <label>父级选择</label>
                                             <span class="help-block">
                                                <i :class="props['error']['parent_id']?'fa-times-circle-o':'fa-info-circle'"
                                                   class="fa"></i>
                                                <span v-show="!props['error']['parent_id']">提示信息</span>
                                                <span v-for="error in props['error']['parent_id']">{{error}}</span>
                                            </span>
                                        <select2 v-model="props['row']['parent_id']" :default-options="maps['parent_id']"
                                                 :url="props['row']['id'] ? '/admin/area/optional-parent/'+props['row']['id']:'/admin/area/optional-parent'"
                                                 :disabled="!props.config['dataUrl']" :keyword-key="'name'" :show="['name']" :is-ajax="true">
                                        </select2>

                                    </div>
                                    <div :class="{'has-error':props['error']['status']}" class="form-group">
                                        <label>状态</label>
                                             <span class="help-block">
                                                <i :class="props['error']['status']?'fa-times-circle-o':'fa-info-circle'"
                                                   class="fa"></i>
                                                <span v-show="!props['error']['status']">提示信息</span>
                                                <span v-for="error in props['error']['status']">{{error}}</span>
                                            </span>
                                        <div class="form-radio">
                                                    <span v-for="(item,index) in maps['status']">
                                                        <input v-model="props['row']['status']" :value="index"
                                                               type="radio" :disabled="!props.config['dataUrl']"> {{item}}
                                                    </span>
                                        </div>

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
            "select2": function (resolve) {
                require(['public/Select2.vue'], resolve);
            }, //选择框异步组件
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