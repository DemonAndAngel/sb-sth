<style>
    .list {
        margin: 0 100px;
        margin-bottom: 30px;
    }
    .card{
        margin:10px;
    }
</style>
<template>
    <div class="list">
        <Card :key="item.id" class="card" v-for="item in list">
            <p slot="title">{{ item.title }}</p>
            <p>
                <markdown-textarea class="content" :value="item.content"
                                   :isPreview="true"></markdown-textarea>
            </p>
        </Card>
    </div>
</template>
<script>
    import MarkdownTextarea from '../libs/MarkdownTextarea.vue';
    import { servicePostList } from '../../service/post';
    export default {
        data() {
            return {
                list:[],
            };
        },
        created(){
            servicePostList((res)=>{
                let meta = res.data.meta;
                if(meta.code === 0){
                    let data = res.data.data;
                    this.list = data.posts;
                }
            },(err)=>{})
        },
        components: {
            MarkdownTextarea
        },
        methods: {

        },
    }
</script>