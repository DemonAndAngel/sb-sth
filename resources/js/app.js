/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import iView from 'iview';
import './src/less/theme.less';
import {WEB_URI} from "./src/service/config";
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(iView);
Vue.component('layout-header', require('./src/components/Header.vue'));
Vue.component('layout-footer', require('./src/components/Footer.vue'));

Vue.component('user-login', require('./src/components/user/Login.vue'));
Vue.component('user-register', require('./src/components/user/Register.vue'));


Vue.component('post-list', require('./src/components/post/List.vue'));
Vue.component('post-edit', require('./src/components/post/Edit.vue'));
Vue.component('post-detail', require('./src/components/post/Detail.vue'));

const app = new Vue({
    el: '#app'
});

axios.interceptors.response.use((res) => {
    if(res.data.meta.code === 403){
        app.$Message.info(res.data.meta.msg);
        window.location.href = WEB_URI.userLogin;
    }
    return res;
});
