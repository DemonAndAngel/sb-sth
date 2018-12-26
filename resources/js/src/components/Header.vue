<style>
    .header{
        padding-bottom: 30px;
        background-color: #fff;
    }
    .menu{
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index:1600 !important;
    }
    .text{
        color:#fff
    }
</style>
<template>
    <div class="header">
        <Header>
            <Menu class="menu" mode="horizontal" theme="dark" :active-name="active_name" @on-select="onSelect" >
                <div class="left">
                    <MenuItem name="index">
                        <Icon type="ios-home" />
                        首页
                    </MenuItem>
                    <MenuItem name="post">
                        <Icon type="ios-paper" />
                        好文章
                    </MenuItem>
                </div>
                <div v-if="Object.keys(user_data).length==0" class="right">
                    <a @click="user('login')" class="text">登录</a>
                    <label class="text">/</label>
                    <a @click="user('register')" class="text">注册</a>
                </div>
                <div v-else class="right">
                    <Submenu name="user">
                        <template slot="title">
                            终于等到你。{{ user_data.nickname }}
                        </template>
                        <MenuGroup title="文章">
                            <MenuItem name="user-post-my">
                                <Icon type="ios-document" />
                                我的文章
                            </MenuItem>
                            <MenuItem name="user-post-edit">
                                <Icon type="ios-create" />
                                说点什么
                            </MenuItem>
                        </MenuGroup>
                        <MenuGroup title="账号">
                            <MenuItem name="user-logout">
                                <Icon type="ios-document" />
                                退出登录
                            </MenuItem>
                        </MenuGroup>
                    </Submenu>
                </div>
            </Menu>
        </Header>
    </div>
</template>
<script>
    import { WEB_URI } from '../service/config';
    import { serviceUserLogout } from '../service/user';
    export default {
        props: {
            active_name: {
                type: String,
                default: 'index'
            },
            user_data:{
                type: Object,
                default:{}
            }
        },
        methods: {
            onSelect(name){
                switch (name){
                    case 'index':
                        window.location.href = WEB_URI.index;
                        break;
                    case 'post':
                        window.location.href = WEB_URI.postList;
                        break;
                    case 'user-post-edit':
                        window.location.href = WEB_URI.postEdit;
                        break;
                    case 'user-logout':
                        serviceUserLogout((res)=>{
                            window.location.href = WEB_URI.userLogin;
                        },(err)=>{
                        })
                        break;
                }

            },
            user(route){
                switch (route){
                    case 'login':
                        window.location.href = WEB_URI.userLogin;
                        break;
                    case 'register':
                        window.location.href = WEB_URI.userRegister;
                        break;
                }
            }
        }
    }
</script>