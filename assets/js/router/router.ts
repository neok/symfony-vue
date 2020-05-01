import Vue from 'vue';
import VueRouter from 'vue-router';
import MovieList from '../components/list/MovieList'
import * as NProgress from "nprogress";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: MovieList
        }
    ]
});


router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start()
    }
    next()
});

router.afterEach((to, from) => {
    NProgress.done()
});

export default router;
