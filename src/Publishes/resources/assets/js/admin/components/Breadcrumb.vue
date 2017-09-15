<template>
    <section class="content-header">
        <h1>
            {{last['name']}}
            <small>{{last['description']}}</small>
        </h1>
        <ol class="breadcrumb" v-if="navs">
            <li v-for="nav in navs" :class="{'active':nav['id']==last['id']}">
                <a :href="nav['url'] ? nav['url']: null" v-if="nav['id']!=last['id']">
                    <i class="fa" :class="nav['icons']"></i> {{nav['name']}}
                </a>
                <span v-if="nav['id']==last['id']">
                     <i class="fa" :class="nav['icons']"></i> {{nav['name']}}
                </span>
            </li>
        </ol>
    </section>
</template>

<script>
    export default {
        data(){
            return this.$store.state.global;
        },
        computed: {
            last(){
                return _.last(this.navs);
            }
        }

    }
</script>
