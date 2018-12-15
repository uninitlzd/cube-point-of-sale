import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import menu from './menu'
import user from './user'
import auth from './auth'
import product from './product'
import shop from './shop'
import outlet from './outlet'

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
    modules: {
        menu,
        auth,
        user,
        product,
        shop,
        outlet
    },
    plugins: [cache, sync]
})
