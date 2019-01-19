import Vue from 'vue'

import './bootstrap'

import router from './router'
import store from './store'
import App from './App.vue'
import VuePersist from 'vue-persist'

Vue.use(VuePersist)

const app = new Vue({
    el: '#app',
    store,
    router,
    components: { App }
});
