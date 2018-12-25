import axios from 'axios'

const types = {
    FETCH_ORDER: 'FETCH_ORDER',
    ADD_ORDER: 'ADD_ORDER',
    EDIT_ORDER: 'EDIT_ORDER',
    DELETE_ORDER: 'DELETE_ORDER'
}

const state = {
    orders: [],
}

const getters = {
    getOrders: state => state.orders,
    getById: state => index => state.orders.filter(order => order.id === index)
}

const mutations = {
    [types.FETCH_ORDER](state, orders) {
        state.orders = orders
    },

    [types.ADD_ORDER](state, order) {
        state.orders.unshift(order)
    },

    [types.EDIT_ORDER](state, {index, order}) {
        state.orders[index] = order
    },

    // Delete Order From State by id
    [types.EDIT_ORDER](state, index) {
        state.orders = state.orders.filter(order => order.id !== index)
    }
}

const actions = {
    async addOrder({commit}, form) {
        let data = await form.post('/api/order')
            .then(data => {
                return data
            })

        commit(types.ADD_ORDER, data)
    },

    async updateOrder({commit}, {form, index}) {
        let order = await form.put('/api/order/' + index)
            .then(order => {
                return order
            })

        commit(types.EDIT_ORDER, {index, order})
    },

    deleteOrder({commit}, index) {
        axios.delete('/api/order/' + index)
            .then(order => {
                return order
            })

        commit(types.EDIT_ORDER, index)
    },

    async fetchOrders({commit}) {
        let data = await axios.get('/api/order')
            .then(response => {

                return response.data
            })

        console.log(data)

        commit(types.FETCH_ORDER, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
