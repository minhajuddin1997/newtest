import Vue from 'vue';
import VueRouter from 'vue-router';
import Routes from './router/index';

Vue.use(VueRouter);
const router = new VueRouter({
    routes:Routes,
    mode:'history'
});
export default router;
