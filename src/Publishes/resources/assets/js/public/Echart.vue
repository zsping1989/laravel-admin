<template>
    <div></div>
</template>
<script>
    require('echarts/build/echarts-all'); //图形
    require('echarts/theme/macarons'); //主题
    export default {
        data(){
            return {
                chart:null,
                initing:true
            };
        },
        props:{
            option:{
                type: [Object]
            },
            resize:{
                type: [Boolean],
                default: function () {
                    return true;
                }
            },
            delay:{
                type: [Number],
                default: function () {
                    return 0;
                }
            }
        },
        methods:{
            init(){
                this.initing = true;
                this.$el.style.display = 'block'; //显示节点
                this.chart = echarts.init(this.$el, 'macarons');
                this.chart.setOption(this.option);
                this.$el.style.display = null; //删除节点样式
                this.initing = false;
            },
            resizefn(){
                //执行重画必须显示div
                this.$el.style.display = 'block'; //显示节点
                this.chart.resize();
                this.$el.style.display = null; //删除节点样式
            }

        },
        computed:{

        },
        mounted() {
            var $this = this;
            setTimeout(this.init,this.delay); //异步执行画图
            //窗口变化重新画图
            window.addEventListener("resize",function() {
                if($this.initing){
                    return false;
                }
                if($this.delay && $($this.$el).css('display')!='block'){
                    setTimeout($this.resizefn,$this.delay);
                }else {
                    $this.resizefn();
                }
            });
        },
        updated(){
            setTimeout(this.init,0);
        }
    }
</script>
