import router from '../../router'
import axios from 'axios'

const types = {
    SET_ACTIVE: 'SET_ACTIVE',
    TOGGLE_CASHIER_VIEW: 'TOGGLE_CASHIER_VIEW',
}

const state = {
    activeIndex: "0",
    cashierView: false
}

const mutations = {
    [types.SET_ACTIVE] (state, index) {
        state.activeIndex = index
    },
    [types.TOGGLE_CASHIER_VIEW] (state, status) {
        state.cashierView = status
    },
}

const getters = {
    activeIndex: state => state.activeIndex,
    cashierView: state => state.cashierView,
}

const actions = {
    setActiveMenuIndex ({ commit }, index) {
        commit(types.SET_ACTIVE, index)
    },
    cashierViewActive({ commit }) {
        commit(types.TOGGLE_CASHIER_VIEW, true)
    },
    cashierViewDeactive({ commit }) {
        commit(types.TOGGLE_CASHIER_VIEW, false)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
