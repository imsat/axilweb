import {createRouter, createWebHistory} from "vue-router";
import Home from "./views/Home.vue";
import Login from "./views/Login.vue";
import Dashboard from "./views/Dashboard.vue";
import PreOrder from "./views/PreOrder.vue";
import {get} from "./utils/localStorage.js";


const routes = [
    {path: '/', name: 'home', component: Home, meta: {title: 'Home', guest: true}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {title: 'Dashboard', guest: false, requiresAuth: true}},
    {path: '/pre-orders', name: 'pre-order', component: PreOrder, meta: {title: 'Pre Order', guest: false, requiresAuth: true}},
    {path: '/login', name: 'login', component: Login, meta: {title: 'Login', guest: true}},

]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'link-secondary'
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (get('token')) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
    document.title = `${to.meta.title}`
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (get('token')) {
            next("/dashboard");
            return;
        }
        next();
    } else {
        next();
    }
    document.title = `${to.meta.title}`
});


export default router;
