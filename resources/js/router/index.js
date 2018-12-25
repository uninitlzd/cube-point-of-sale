import VueRouter from 'vue-router'
import store from '../store'

import Home from '../components/Home.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import ForgotPassword from '../components/ForgotPassword.vue'
import Dashboard from '../components/Dashboard.vue'
import { getState } from '../store/plugins/storage';

import category from "./category";
import product from "./product";
import outlet from "./outlet";
import order from "./order";
import material from "./material";
import report from "./report";
import employee from "./employee";
import member from "./member";

const router = new VueRouter({
    routes: [
        {
            path: '/',
            redirect: '/dashboard'
        },
        {

            path: '/login',
            name: 'Login',
            component: Login,
            meta: {
                auth:false
            }
        },
        {

            path: '/register',
            name: 'Register',
            component: Register,
            meta: {
                auth:false
            }
        },
        {

            path: '/forgot',
            name: 'Forgot',
            component: ForgotPassword,
            meta: {
                auth:false
            }
        },
        {
            path: '/dashboard',
            name: 'Dashboard',
            component: Dashboard  ,
            meta: {
                auth: true
            }
        },
        ...category,
        ...product,
        ...outlet,
        ...order,
        ...material,
        ...report,
        ...employee,
        ...member,
        {
            path: '*',
            redirect: '/'
        },
    ]
})

router.beforeEach((to, from, next) => {
    console.log(store.state.initialized)

        getState().then(state => {
            console.log(state)
            if (!store.state.initialized) {
                store.commit('loadFromCache', state)
            }
        }).then(() => {
            if (!store.getters['auth/isLogged'] && to.meta.auth) {
                return next('/login')
            }

            if (store.getters['auth/isLogged'] && to.name === 'Login') {
                return next('/')
            }

            next()
        })

})

router.afterEach((to, from) => {
    switch (to.name) {
        case 'Login':
            break;
        case 'Register':
            break;
        default:
            store.dispatch('setActiveMenuIndex', to.meta.menuIndex)
    }
})

export default router
