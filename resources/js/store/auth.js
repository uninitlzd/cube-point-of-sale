import router from '../router'
import axios from 'axios'
import {setState, deleteState} from './plugins/storage'

const types = {
    INIT_AUTH: 'INIT_AUTH',
    LOGIN: 'LOGIN',
    LOGOUT: 'LOGOUT',
}

const state = {
    logged: false,
    user: null
}

const mutations = {
    [types.LOGIN](state, user) {
        state.logged = true
        state.user = user
    },

    [types.LOGOUT](state) {
        deleteState()
        state.logged = false
    },

    [types.INIT_AUTH](state) {
        console.log(state)
    }
}

const getters = {
    isLogged: state => state.logged
}

const actions = {
    async login({commit, dispatch}, form) {
        let data = await form.post('/api/login')
            .then(data => {
                return data
            })

        window.localStorage.setItem('token', data.access_token)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.token

        commit(types.LOGIN, data.user)
        dispatch('shop/setShop', data.user.shop, {root: true})
        router.push({name: 'Dashboard'})
    },

    async register({commit, dispatch}, form) {
        let data = await form.post('/api/register')
            .then(data => {
                return data
            })


        window.localStorage.setItem('token', data.access_token)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.token

        commit(types.LOGIN, data.user)
        dispatch('shop/setShop', data.user.shop, {root: true})
        router.push({name: 'Dashboard'})
    },

    logout({commit}) {
        commit(types.LOGOUT)

        delete axios.defaults.headers.common['Authorization']
        deleteState().then(() => {
            router.push({name: 'Login'})
        })
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
