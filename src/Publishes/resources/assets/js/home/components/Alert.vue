<template>
    <div v-show="count">
        <div v-for="alert in alerts" v-if="alert['show']" :class="['alert-'+alert['type'], alert['position'],alert['customClass']]" role="alert" class="fade-transition alert fade-leave" >
            <button type="button" class="close" v-if="alert['showClose']" @click="alert['show']=false">
                <span>×</span>
            </button>
            <span class="icon-info-circled alert-icon-float-left"></span>
            <strong v-show="alert['title']">
                <i class="icon fa" :class="alert['iconClass'] ? alert['iconClass'] : 'fa-'+alert['type']"></i>
                {{alert['title']}}
            </strong>
            <p v-show="alert['message']">{{alert['message']}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {};
        },
        computed: {
            alerts(){
                let alerts = this.$store.state.alerts;
                for (let index in alerts){
                    if(alerts[index]['duration']){
                        setTimeout(function(){
                            alerts[index]['show'] = false;
                        },alerts[index]['duration'])
                    }
                }
                return alerts;
            },
            count(){
                return this.alerts.length;
            }
        }
    }
</script>
