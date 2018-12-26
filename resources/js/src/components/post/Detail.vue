<style>
    .detail {
        margin: 0 100px;
        margin-bottom: 30px;
    }
</style>
<template>
    <div class="detail">
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
    export default {
        props:{
            post_data:{
                type:Object,
                default:{}
            }
        },
        data() {
            return {

            };
        },
        created(){

        },
        components: {
            MarkdownTextarea
        },
        methods: {

        },
    }
</script>