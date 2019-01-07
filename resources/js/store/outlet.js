import axios from 'axios'

const types = {
    FETCH_OUTLET: 'FETCH_OUTLET',
    ADD_OUTLET: 'ADD_OUTLET',
    EDIT_OUTLET: 'EDIT_OUTLET',
    DELETE_OUTLET: 'DELETE_OUTLET'
}

const state = {
    outlets: [],
}

const getters = {
    getOutlets: state => state.outlets,
    getById: state => index => state.outlets.filter(outlet => outlet.id === index)
}

const mutations = {
    [types.FETCH_OUTLET](state, outlets) {
        state.outlets = outlets
    },

    [types.ADD_OUTLET](state, outlet) {
        state.outlets.unshift(outlet)
    },

    [types.EDIT_OUTLET](state, {index, outlet}) {
        state.outlets[state.outlets.findIndex(outlet => outlet.id)] = outlet
    },

    // Delete Outlet From State by id
    [types.DELETE_OUTLET](state, index) {
        state.outlets = state.outlets.filter(outlet => outlet.id !== index)
    }
}

const actions = {
    setShop({commit}, shop) {
        commit(types.SET_SHOP, shop)
    },
    async addOutlet({commit}, form) {
        let data = await form.post('/api/outlet')
            .then(data => {
                return data
            })

        commit(types.ADD_OUTLET, data)
    },

    async updateOutlet({commit}, {form, index}) {
        let outlet = await form.put('/api/outlet/' + index)
            .then(outlet => {
                return outlet
            })

        commit(types.EDIT_OUTLET, {index, outlet})
    },

    deleteOutlet({commit}, index) {
        axios.delete('/api/outlet/' + index)
            .then(outlet => {
                return outlet
            })

        commit(types.DELETE_OUTLET, index)
    },

    async fetchOutlets({commit}) {
        let data = await axios.get('/api/outlet')
            .then(response => {

                return response.data
            })

        console.log(data)

        commit(types.FETCH_OUTLET, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
