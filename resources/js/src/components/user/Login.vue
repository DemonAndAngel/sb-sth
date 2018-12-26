<style>
    .login{
        display: flex;
        align-content: center;
        justify-content: center;
    }
    .login-form{
        width:300px;
        display: flex;
        flex-direction: column;
        border: 1px solid #dadada;
        border-radius: 10px;
    }
    .login-header{
        padding: 12px 14px;
    }
    .login-body{
        padding: 12px 14px;
    }
    .button-group{
        margin: 0;
        text-align: right;
    }
    .button-item{
        width:100%;
    }
</style>
<template>
    <div class="login">
        <div class="login-form">
            <div class="login-header"></div>
            <Form class="login-body" ref="formLogin" :model="formInput" :rules="formRule">
                <FormItem prop="account">
                    <Input type="text" v-model="formInput.account" placeholder="账号">
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem prop="password">
                    <Input type="password" v-model="formInput.password" placeholder="密码">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem class="button-group">
                    <Button class="button-item" type="primary" @click="submit">登录</Button>
                    <a class="button-item" @click="register">没有帐号？注册</a>
                </FormItem>
            </Form>
        </div>
    </div>
</template>
<script>
    import { serviceUserLogin } from '../../service/user';
    import {WEB_URI} from '../../service/config';

    export default {
        props:{
            url:{
                type:String,
                default:''
            }
        },
        data () {
            return {
                formInput: {
                    account: '568089002',
                    password: 'lan0728'
                },
                formRule: {
                    account: [
                        { required: true, message: '请输入用户名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                    ]
                }
            }
        },
        methods: {
            submit() {
                this.$refs['formLogin'].validate((valid) => {
                    if (valid) {
                        serviceUserLogin(this.formInput.account,this.formInput.password,(res)=>{
                            let meta = res.data.meta;
                            if(meta.code !== 0){
                                this.$Message.error(meta.msg);
                            }else{
                                if(this.url){
                                    window.location.href = this.url;
                                }else{
                                    window.location.href = WEB_URI.index;
                                }
                            }
                        },(err)=>{

                        })
                    }
                })
            },
            register(){
                window.location.href = WEB_URI.userRegister;
            }
        }
    }
</script>