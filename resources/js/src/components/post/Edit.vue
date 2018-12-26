<style>
    .submit {
        margin: 0 100px;
    }

    .button {
        width: 100px;
        margin: 0 10px;
    }

    .content {
        height: 500px !important;
    }
</style>
<template>
    <div class="submit">
        <Form>
            <FormItem>
                <Input v-model="formInput.title" placeholder="输入文章标题"></Input>
            </FormItem>
            <FormItem >
                <markdown-textarea class="content" :value="formInput.content"
                                   placeholder="输入文章内容"
                                   @changeValue="changeValue"
                                   :isPreview="false"></markdown-textarea>
            </FormItem>
            <FormItem style="text-align: center">
                <Button class="button" type="primary" @click="submit" :disabled="disabled">发布</Button>
                <Button class="button">取消</Button>
            </FormItem>
        </Form>
    </div>
</template>
<script>
    import MarkdownTextarea from '../libs/MarkdownTextarea.vue';
    import { servicePostDraft,servicePostRelease } from '../../service/post';
    import { WEB_URI } from '../../service/config';
    export default {
        props:{
            post_data:{
                type: Object,
                default:{
                    id:0,
                    title:'',
                    content:'',
                    updated_at:'',
                    released_at:'',
                }
            },
        },
        data() {
            return {
                formInput:{},
                disabled:false,
            }
        },
        created(){
          this.formInput = this.post_data
        },
        components: {
            MarkdownTextarea
        },
        methods: {
            changeValue(value) {
                this.post_data.content = value
            },
            submit() {
                this.disabled = true;
                this.$Loading.start();
                servicePostDraft(this.formInput.id,this.formInput.title,this.formInput.content,(res)=>{
                    let meta = res.data.meta;
                    if(meta.code !== 0){
                        this.$Message.error(meta.msg);
                        this.error();
                    }else{
                        let data = res.data.data;
                        this.formInput = data.post;
                        servicePostRelease(this.formInput.id,
                            (res)=>{
                                meta = res.data.meta;
                                if(meta.code !== 0){
                                    this.$Message.error(meta.msg);
                                    this.error();
                                }else{
                                    data = res.data.data;
                                    this.$Message.success('发布成功');
                                    window.location.href = WEB_URI.postDetail+'/'+data.post.id;
                                }
                                this.$Loading.finish();
                            },
                            (err)=>{
                                this.error();
                            }
                        )
                    }
                },(err)=>{
                    this.error();
                })
            },
            error(){
                this.$Loading.error();
                this.disabled = false;
            }
        },
    }
</script>