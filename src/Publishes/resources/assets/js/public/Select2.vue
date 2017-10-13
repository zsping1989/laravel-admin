<template>
    <select class="form-control" :disabled="disabled" :multiple="multiple" style="width: 100%;">
        <option :value="placeholderValue">请选择</option>
        <option v-for="option in options" :value="option['id']" :selected="selected(option['id'])">{{option['text']}}</option>
    </select>
</template>
<script>
    try {
        if(!window.jQuery){
            window.$ = window.jQuery = require('jquery');
        }
    } catch (e) {
    }
    require('select2');
    require('select2/dist/js/i18n/zh-CN.js');
    export default {
        data(){
            return {};
        },
        props:{
            //绑定值
            value: {
                type:[String, Number,Array],
                default: function () {
                    return '';
                }
            },
            //默认选项
            defaultOptions:{
                type: [Object,Array],
                default: function () {
                    return [];
                }
            },
            //请求数据地址
            url:{
                type:[String],
                default: function () {
                    return '';
                }
            },
            //请求参数
            params:{
                type: [Object,Array],
                default: function () {
                    return {where:{},order:{}};
                }
            },
            //搜索关键字KEY
            keywordKey:{
                type:[String],
                default: function () {
                    return 'keyword';
                }
            },
            isAjax:{
                type:[Boolean],
                default: function () {
                    return false;
                }
            },
            placeholderValue:{
                type:[String,Number],
                default: function () {
                    return 0;
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            multiple:{
                type:[String],
                default: function () {
                    return null;
                }
            },
            show:{
                type:[Array],
                default: function () {
                    return ['name'];
                }
            }
        },
        computed: {
            options(){
                var options = this.defaultOptions;
                if(!options){
                    return [];
                }
                var text, i, j,row;
                for(i in options){
                    row = options[i];
                    text = '';
                    if(typeof row['text']=='undefined'){
                        for (j in this.show){
                            if(j==0){
                                text = array_get(row,this.show[j]);
                            }else {
                                text += array_get(row,this.show[j]) ? '（'+array_get(row,this.show[j])+'）':'';
                            }
                        }
                        options[i]['text'] = text;
                    }
                }
                return options;
            }
        },
        methods:{
            copyObj:function(obj){
                return JSON.parse(JSON.stringify(obj));
            },
            initSelect2(){
                var $this = this;
                if(this.isAjax){
                    $(this.$el).select2({
                        maximumSelectionLength: 10,
                        language: "zh-CN",
                        ajax: {
                            url: this.url,
                            dataType: 'json',
                            delay: 250,
                            //搜索参数
                            data: function (params) {
                                var params_data = $this.copyObj($this.params);
                                if(!params_data.where){
                                    params_data.where = {};
                                }
                                params_data.where[$this.keywordKey] = params['term'] || '';
                                params_data['page'] = params['page'] || 1;
                                return params_data;
                            },
                            //最后一页
                            processResults: function (data, params) {
                                params.page = params.page || 1;
                                var text, i, j,row;
                                for(i in data.data){
                                    row = data.data[i];
                                    text = '';
                                    if(typeof row['text']=='undefined'){
                                        for (j in $this.show){
                                            if(j==0){
                                                text = array_get(row,$this.show[j]);
                                            }else {
                                                text += array_get(row,$this.show[j]) ? '（'+array_get(row,$this.show[j])+'）':'';
                                            }
                                        }
                                        data.data[i]['text'] = text;
                                    }
                                }
                                return {
                                    results: data.data,
                                    pagination: {
                                        more: data.current_page < data.last_page
                                    }
                                };
                            },
                            cache: true
                        }
                    });
                }else {
                    $(this.$el).select2({
                        language: "zh-CN",
                        maximumSelectionLength: 10
                    });
                }
            },
            selected(value){
                if(this.multiple){
                    var flog = false;
                    for (var i in this.value){
                        if(this.value[i]==value){
                            flog = true;
                            break;
                        }
                    }
                    return flog ? 'selected' : null;
                }else {
                    return value==this.value ? 'selected':null;
                }
            }
        },
        mounted() {
            var $this = this;
            this.initSelect2();
            $(this.$el).on('change',function(){
                var value = $(this).val();
                $this.$emit('input', value); //修改值
                $this.$emit('change',value); //修改值
            });
        },
        updated(){
            this.initSelect2();
        }
    }
</script>
