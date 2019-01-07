import Vue from 'vue'

import './bootstrap'

import router from './router'
import store from './store'
import App from './App.vue'

const app = new Vue({
    el: '#app',
    store,
    router,
    components: { App }
});

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
}

