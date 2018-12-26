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
            <a slot="title" @click="detail(item.id)">{{ item.title }}</a>
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
    import { WEB_URI } from '../../service/config';
    export default {
        data() {
            return {
                list:[],
            };
        },
        created(){
            this.$Loading.start();
            servicePostList((res)=>{
                let meta = res.data.meta;
                if(meta.code === 0){
                    let data = res.data.data;
                    this.list = data.posts;
                }
                this.$Loading.finish();
            },(err)=>{
                this.$Loading.error();
            })
        },
        components: {
            MarkdownTextarea
        },
        methods: {
            detail:(id)=>{
                window.location.href = WEB_URI.postDetail+'/'+id;
            }
        },
    }
</script>