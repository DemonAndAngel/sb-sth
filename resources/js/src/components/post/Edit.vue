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
        data() {
            return {
                post_id:0,
                formInput: {
                    title: '',
                    content: ''
                },
                disabled:false,
            };
        },
        components: {
            MarkdownTextarea
        },
        methods: {
            changeValue(value) {
                this.formInput.content = value
            },
            submit() {
                this.disabled = true;
                this.$Loading.start();
                servicePostDraft(this.post_id,this.formInput.title,this.formInput.content,(res)=>{
                    let meta = res.data.meta;
                    if(meta.code !== 0){
                        this.$Message.error(meta.msg);
                        this.error();
                    }else{
                        let data = res.data.data;
                        this.post_id = data.post_id;
                        servicePostRelease(this.post_id,
                            (res)=>{
                                meta = res.data.meta;
                                if(meta.code !== 0){
                                    this.$Message.error(meta.msg);
                                    this.error();
                                }else{
                                    data = res.data.data;
                                    this.$Message.success('发布成功');
                                    window.location.href = WEB_URI.postDetail+'/'+data.post_id;
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