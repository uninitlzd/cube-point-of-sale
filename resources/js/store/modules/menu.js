import router from '../../router'
import axios from 'axios'

const types = {
    SET_ACTIVE: 'SET_ACTIVE',
}

const state = {
    activeIndex: "0"
}

const mutations = {
    [types.SET_ACTIVE] (state, index) {
        state.activeIndex = index
    },
}

const getters = {
    activeIndex: state => state.activeIndex
}

const actions = {
    setActiveMenuIndex ({ commit }, index) {
        commit(types.SET_ACTIVE, index)
    },
}

export default {
    namespace: true,
    state,
    mutations,
    getters,
    actions
}
