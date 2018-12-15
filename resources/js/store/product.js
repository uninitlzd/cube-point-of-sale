import router from '../router'

import axios from 'axios'

const types = {
    INDEX: 'INDEX',
    SHOW: 'SHOW',
    CREATE: 'CREATE',
    EDIT: 'EDIT',
    DELETE: 'DELETE',
    SET_TOTAL: 'SET_TOTAL'
}

const state = {
    products: [],
    total: 0
}

const getters = {
    products: state => state.products
}

const mutations = {
    [types.INDEX](state, payload) {
        state.products = payload
    },
    [types.SET_TOTAL] (state, payload) {
        state.total = payload
    }
}

const actions = {
    getProducts({commit}, payload) {
        axios.get('/api/product', {
                params: {
                    ...payload
                }
            })
            .then(r => r.data)
            .then(products => {
                commit(types.INDEX, products.data)
                commit(types.SET_TOTAL, products.meta.total)
            });
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
