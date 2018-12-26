<style>
    .detail {
        margin: 0 100px;
        margin-bottom: 30px;
    }
</style>
<template>
    <div class="detail">
        <a @click="edit(post_data.id)" v-if="is_edit">编辑</a>
        <p slot="title">{{ post_data.title }}</p>
        <p>
            <markdown-textarea class="content" :value="post_data.content"
                               :isPreview="true"></markdown-textarea>
        </p>
    </div>
</template>
<script>
    import MarkdownTextarea from '../libs/MarkdownTextarea.vue';
    import { servicePostDetail } from '../../service/post';
    import { WEB_URI } from '../../service/config';
    export default {
        props:{
            post_data:{
                type:Object,
                default:{}
            },
            is_edit:{
                type:Number,
                default:0
            }
        },
        data() {
            return {

            };
        },
        components: {
            MarkdownTextarea
        },
        methods: {
            edit(id){
                window.location.href = WEB_URI.postEdit+'/'+id;
            }
        },
    }
</script>