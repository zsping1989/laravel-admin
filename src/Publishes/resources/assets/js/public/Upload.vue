<template>
    <div>
        <el-upload class="avatar-uploader"
                :action="action"
                :show-file-list="false"
                :on-success="handleAvatarSuccess" name="upfile"
                :before-upload="beforeAvatarUpload">
            <img v-if="value" :src="value" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
    </div>
</template>
<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader input{
        display: none;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
<script>
    require(['element-ui/lib/theme-default/upload.css']);
    import ElUpload from 'element-ui/lib/upload';
    export default {
        components: {
            'el-upload':ElUpload
        },
        data(){
            return {
            };
        },
        props:{
            value: {
                type:[String],
                default: function () {
                    return '';
                }
            },
            disabled:{
                default: function () {
                    return false;
                }
            },
            action:{
                default: function () {
                    return '/ueditor/server?action=upload-image';
                }
            }
        },
        methods:{
            handleAvatarSuccess(res, file){
                if(res.state=='SUCCESS'){
                    this.$emit('input',res.url ); //修改值
                    this.$emit('change',res.url); //修改值
                }
            },
            beforeAvatarUpload(){

            }
        },
        computed:{

        },
        watch:{

        },
        mounted() {

       },
        updated(){

        }
    }
</script>
