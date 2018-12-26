<style>
    .register{
        display: flex;
        align-content: center;
        justify-content: center;
    }
    .register-form{
        width:300px;
        display: flex;
        flex-direction: column;
        border: 1px solid #dadada;
        border-radius: 10px;
    }
    .register-header{
        padding: 12px 14px;
    }
    .register-body{
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
    <div class="register">
        <div class="register-form">
            <div class="register-header"></div>
            <Form class="register-body" ref="formRegister" :model="formInput" :rules="formRule">
                <FormItem prop="account">
                    <Input type="text" v-model="formInput.account" placeholder="账号">
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem prop="nickname">
                    <Input type="text" v-model="formInput.nickname" placeholder="昵称">
                    <Icon type="ios-flame-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem prop="password">
                    <Input type="password" v-model="formInput.password" placeholder="密码">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem prop="password_c">
                    <Input type="password" v-model="formInput.password_c" placeholder="确认密码">
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                    </Input>
                </FormItem>
                <FormItem class="button-group">
                    <Button class="button-item" type="primary" @click="submit">注册</Button>
                    <a class="button-item" @click="login">已有帐号？登录</a>
                </FormItem>

            </Form>
        </div>
    </div>
</template>
<script>
    import { serviceUserRegister } from '../../service/user';
    import {WEB_URI} from '../../service/config';
    export default {
        props:{
            url:{
                type:String,
                default:''
            }
        },
        data () {
            let validatePasswordC = (rule, value, callback)=>{
                let password = this.formInput.password
                if(value !== password) {
                    return callback(new Error("两次输入密码不一致"));
                }else{
                    callback();
                }
            };
            return {
                formInput: {
                    account: '',
                    password: '',
                    nickname: '',
                    password_c: ''
                },
                formRule: {
                    account: [
                        { required: true, message: '请输入用户名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                    ],
                    nickname: [
                        { required: true, message: '请输入昵称', trigger: 'blur' },
                    ],
                    password_c: [
                        {required: true, message: '请输入确认密码', trigger: 'blur'},
                        {validator: validatePasswordC, trigger: 'blur'}
                    ],
                }
            }
        },
        methods: {
            submit() {
                this.$refs['formRegister'].validate((valid) => {
                    if (valid) {
                        serviceUserRegister(
                            this.formInput.account,
                            this.formInput.password,
                            this.formInput.nickname,
                            (res)=>{
                                let meta = res.data.meta;
                                if(meta.code !== 0)
                                    this.$Message.error(meta.msg);
                                else{
                                    if(this.url){
                                        window.location.href = this.url;
                                    }else{
                                        window.location.href = WEB_URI.index;
                                    }
                                }
                            },
                            (err)=> {

                            }
                        )
                    }
                })
            },
            login(){
                window.location.href = WEB_URI.userLogin;
            }
        }
    }
</script>