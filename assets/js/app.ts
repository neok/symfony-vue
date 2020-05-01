
import Vue from 'vue'
import App from './App.vue'
import router from './router/router';
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'nprogress/nprogress.css';
import './assets/scss/main.scss';
import store from './store';
import { sync } from 'vuex-router-sync';



Vue.use(BootstrapVue);
sync(store, router);
Vue.config.productionTip = false;

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App }
});

