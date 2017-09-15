<template>
    <div>
        <link rel="stylesheet" href="/css/zTreeStyle/zTreeStyle.css" type="text/css">
        <ul class="ztree" :id="'ztree_'+id"></ul>
    </div>
</template>
<script>
    try {
        if(!window.jQuery){
            window.$ = window.jQuery = require('jquery');
        }
    } catch (e) {
    }
    require('ztree/js/jquery.ztree.all.min');
    export default {
        data(){
            return {changeing:false,ztree:null};
        },
        props:{
            //ztree配置
            config:{
                type: Object,
                default: function () {
                    return {
                        check: {
                            enable: true,
                            chkboxType: {"Y": "ps", "N": "s"}
                        },
                        data: {
                            simpleData: {
                                enable: true,
                                pIdKey: "parent_id",
                                rootPId: 0
                            }
                        },
                        view: {
                            showIcon: false,
                            dblClickExpand: false
                        },
                        callback: {
                            onCheck: function (e, id, node) {
                                var ztree = this.getZTreeObj($(e.currentTarget).attr('id'));
                                if(ztree.vue.multiple){
                                    var checked = ztree.getCheckedNodes();
                                    var data = [];
                                    for (var i in checked) {
                                        data[i] = {'id':checked[i]['id']};
                                    }
                                }else {
                                    var data = node.id;
                                }
                                ztree.vue.changeing = true;
                                ztree.vue.$emit('input', data); //修改值
                                ztree.vue.$emit('change',data); //修改值
                            }
                        }
                    };
                }
            },
            //绑定值
            value: {
                type:[String, Number,Array],
                default: function () {
                    return [];
                }
            },
            //默认选项
            data:{
                type: [Object,Array],
                default: function () {
                    return [];
                }
            },
            expandAll:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            id:{
                type: [String]
            },
            multiple:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            chkboxType:{
                type: [Object],
                default: function () {
                    return {"Y": "ps", "N": "s"};
                }
            },
            checkEnable:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            }
        },
        methods:{
            init(){
                setTimeout(()=>{
                    let ztree = $.fn.zTree.init($(this.$el).find('ul'),this.mainConfig,this.data);
                    ztree.vue = this;
                    this.ztree = ztree;
                    if(this.expandAll){
                        ztree.expandAll(true); //全部展开
                    }
                    if(!this.multiple){
                        ztree.selectNode(ztree.getNodeByParam("id", this.value));
                    }else {
                        //选中值
                        for (var i in this.value) {
                            this.ztree.checkNode(this.ztree.getNodeByParam("id", this.value[i]['id']),true,false);
                        }
                    }
                },0)

            },
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            }
        },
        mounted() {
            this.init();
        },
        watch:{
            //重置数据还原
            value(value,oldValue){
                if(!this.changeing){
                    if(!this.multiple){
                        this.ztree.cancelSelectedNode(this.ztree.getNodeByParam("id", oldValue));
                        this.ztree.selectNode(this.ztree.getNodeByParam("id", value));
                    }else {
                        //取消旧勾选
                        for (var i in oldValue) {
                            this.ztree.checkNode(this.ztree.getNodeByParam("id", oldValue[i]['id']),false,false);
                        }
                        for (var i in value) {
                            this.ztree.checkNode(this.ztree.getNodeByParam("id", value[i]['id']),true,false);
                        }
                    }
                }
                this.changeing = false;
            }
        },
        computed:{
            mainConfig(){
                var config = this.config;
                config.check.chkboxType = this.chkboxType;
                config.check.enable = this.checkEnable;
                if(!this.checkEnable){
                    config.callback.onClick = config.callback.onCheck;
                }
                return config;
            }
        },
        updated(){
            this.init();
        }
    }
</script>
