<template>
    <form action="config['dataUrl']" method="post">
        <div class="row">
            <slot :row="row" :error="error" :config="config">
            </slot>
        </div>
        <div class="row">
            <slot name="footer" :row="row" :error="error" :submit="submitForm" :reset="resetForm">
                <div class="col-lg-12">
                    <div class="box-footer">
                        <div class="col-xs-6">
                            <button type="button" :disabled="config['dataUrl'] ? null : 'disabled'"  @click="submitForm" class="btn btn-info pull-right">提交</button>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-default reset" @click="resetForm">重置</button>
                        </div>
                    </div>
                </div>
            </slot>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            ftxConfig: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            ftxData: {
                type: Object,
                default: function () {
                    return {};
                }
            }
        },
        data() {
            var old = JSON.parse(JSON.stringify(this.ftxData));
            return {
                defaultConfig: {
                    dataUrl: '', //数据提交地址
                    backUrl: '' //提交成功后返回地址
                },
                row: this.ftxData,
                old: old,
                error: {},
                submiting:false
            };
        },
        computed: {
            config: function () {
                var config = {};
                for (var i in this.defaultConfig) {
                    if (typeof this.ftxConfig[i] != 'undefined') {
                        config[i] = this.ftxConfig[i];
                    } else {
                        config[i] = this.defaultConfig[i];
                    }
                }
                if (typeof this.row.id != 'undefined' && this.row['id'] && config['dataUrl']) {
                    config['dataUrl'] = config['dataUrl'] + '/' + this.row['id'];
                }
                return config;
            }
        },
        methods: {
            submitForm() {
                var $this = this;
                if(this.submiting){
                    return ;
                }
                this.submiting = true;
                axios.post($this.config['dataUrl'], $this.row).then(function (response) {
                    if (/*typeof $this.row.id != 'undefined' && $this.row.id &&*/ $this.config['backUrl']) {
                        window.setTimeout(function () {
                            window.location.href = $this.config['backUrl'];
                        }, 2500);
                    }
                    $this.error = {};
                }).catch(function (error) {
                    $this.error = catchError(error);
                    $this.$store.commit('alert', {
                        'showClose': true,
                        'title': '操作失败!',
                        'position': 'top',
                        'message': '',
                        'type': 'danger',
                        'iconClass': '',
                        'customClass': '',
                        'duration': 3000,
                        'show': true
                    });
                    $this.submiting = false;
                })
            },
            //重置表单
            resetForm() {
                this.error = {};
                this.row = this.copyObj(this.old);
            },
            copyObj: function (obj) {
                return JSON.parse(JSON.stringify(obj));
            }
        }

    }
</script>

