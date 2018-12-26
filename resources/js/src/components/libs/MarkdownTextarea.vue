<style>
    .md-editor{
        height: 100%;
    }
</style>
<template>
    <div class="md-editor">
        <mavon-editor
                :style="mdStyle"
                ref="md"
                class="md-editor"
                :value="value"
                :placeholder="placeholder"
                :toolbarsFlag="toolbarsFlag"
                :subfield="subfield"
                :defaultOpen="defaultOpen"
                @change="changeValue"
                @imgAdd="$imgAdd"
                @fullScreen="$fullScreen"
        >
        </mavon-editor>
    </div>
</template>
<script>
    import {mavonEditor} from 'mavon-editor'
    import 'mavon-editor/dist/css/index.css'
    import { serviceImgAdd } from '../../service/file'

    export default {
        name: 'md-editor',
        props: {
            placeholder: {
                type: String,
                default: ''
            },
            value:{
                type: String,
                default: ''
            },
            isPreview:{
                type:Boolean,
                default:false
            },
        },
        created(){
            if(this.isPreview){
                this.toolbarsFlag = false;
                this.subfield = false;
                this.defaultOpen = 'preview';
            }
        },
        data(){
            return {
                toolbarsFlag:true,
                subfield:true,
                defaultOpen:'',
                file_list:[],
                mdStyle:"z-index:1 !important"
            }
        },
        components: {
            mavonEditor
        },
        methods: {
            changeValue(value){
                this.$emit('changeValue',value)
            },
            // 绑定@imgAdd event
            $imgAdd(pos, $file) {
                // 第一步.将图片上传到服务器.
                serviceImgAdd($file,'POST',(res) => {
                    let data = res.data;
                    let meta = data.meta;
                    let $vm = this.$refs.md;
                    if (meta.code !== 0) {
                        $vm.$refs.toolbar_left.$imgDelByFilename($file);
                        return false;
                    } else {
                        data = data.data;
                        $vm.$img2Url(pos, data.img_data.url);
                        return true;
                    }
                });
            },
            $fullScreen(status){
                if(status){
                    this.mdStyle = 'z-index:9999 !important';
                }else{
                    this.mdStyle = 'z-index:1 !important';
                }
            }
        }
    }
</script>