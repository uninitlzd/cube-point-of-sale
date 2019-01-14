import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import modules from './modules'

import cache from './plugins/cache'
import sync from './plugins/sync'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        initialized: false
    },
    mutations: {
        loadFromCache(state, cached) {
            console.log(cached)
            if (cached) {
                Object.keys(cached).forEach((key) => {
                    state[key] = Object.assign({}, state[key], cached[key]);
                });
            }
            state.initialized = true;
        }
    },
    modules,
    plugins: [cache, sync]
})
