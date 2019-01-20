import router from './../../router'
import axios from 'axios'
import {setState, deleteState} from './../plugins/storage'

const types = {
    INIT_AUTH: 'INIT_AUTH',
    LOGIN: 'LOGIN',
    LOGOUT: 'LOGOUT',
}

const state = {
    logged: false,
    user: null,
    shop_outlet_id: 0
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
    isLogged: state => state.logged,
    getUser: state => state.user,
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

    async logout({commit}) {
        commit(types.LOGOUT)

        //Todo: check internet connection
        //If have internet connection
        axios.post('/api/logout', {
            token: window.localStorage.getItem('token')
        })

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
