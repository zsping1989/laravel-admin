<template>
    <div class="modal fade in" style="display:block" v-if="modal">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top: 40%">
                <div class="modal-header">
                    <button type="button" class="close" @click="close">
                        <span>×</span></button>
                    <h4 class="modal-title">{{modal['title']}}</h4>
                </div>
                <div class="modal-body">
                    <p>{{modal['content']}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" @click="close">关闭</button>
                    <button type="button" class="btn btn-primary" @click="callback">确定</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {};
        },
        computed: {
            modal(){
                return this.$store.state.modal;
            }
        },
        methods:{
            close(){
                this.$store.commit('modal', null);
            },
            callback(){
                if(typeof this.modal.callback=="function"){
                    this.modal.callback();
                }
                this.close();
            }
        }
    }
</script>
