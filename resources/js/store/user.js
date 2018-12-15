import router from '../router'
import axios from 'axios'

const types = {
    INITIALIZING: 'INITIALIZING'
}

const state = {
    initStatus: false
}

const mutations = {
    [types.INITIALIZING] (state) {
        state.initStatus = true
    },
}

const getters = {
    isInitialized: state => state.initStatus
}

const actions = {
    initializing ({ commit }, data) {
        commit(types.INITIALIZING)
    },
}

export default {
    state,
    mutations,
    getters,
    actions
}
