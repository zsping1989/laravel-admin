<template>
    <div class="input-group colorpicker-component">
        <link rel="stylesheet" href="/css/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" type="text/css">
        <input type="text" :value="value" class="form-control" />
        <span class="input-group-addon"><i></i></span>
    </div>
</template>
<script>
    try {
        if(!window.jQuery){
            window.$ = window.jQuery = require('jquery');
        }
    } catch (e) {
    }
    require('bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min');
    export default {
        data(){
            return {
                changeing:false,
                old_color:''
            };
        },
        props:{
            value: {
                type:[String, Number],
                default: function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            }
        },
        methods:{


        },
        computed:{

        },
        watch:{
            value(value,oldValue){
                if(!this.changeing){
                    if(!value){
                        $(this.$el).colorpicker();
                    }else {
                        this.colorpicker.colorpicker('setValue', value);
                    }
                }
                this.changeing = false;
            },
            disabled(value,oldValue){
                if(value){
                    this.colorpicker.colorpicker('enable');
                }else {
                    this.colorpicker.colorpicker('disable');
                }
            }
        },
        mounted() {
            var $this = this;
            $this.colorpicker = $(this.$el).colorpicker();
            if(this.disabled){
                this.colorpicker.colorpicker('disable');
            }
            $this.colorpicker.on('changeColor', function(e,a,b) {
                var value = e.color.toString( 'rgba');
                if(value==$this.old_color){
                    return ;
                }
                $this.old_color = value;
                $this.changeing = true;
                $this.$emit('input', value); //修改值
                $this.$emit('change',value); //修改值
            });
       },
        updated(){

        }
    }
</script>
