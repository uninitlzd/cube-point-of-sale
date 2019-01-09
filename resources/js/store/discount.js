import axios from 'axios'

const types = {
    FETCH_DISCOUNT: 'FETCH_DISCOUNT',
    ADD_DISCOUNT: 'ADD_DISCOUNT',
    EDIT_DISCOUNT: 'EDIT_DISCOUNT',
    DELETE_DISCOUNT: 'DELETE_DISCOUNT'
}

const state = {
    discounts: [],
}

const getters = {
    getDiscounts: state => state.discounts,
    getById: state => index => state.discounts.filter(discount => discount.id === parseInt(index))[0]
}

const mutations = {
    [types.FETCH_DISCOUNT](state, discounts) {
        state.discounts = discounts
    },

    [types.ADD_DISCOUNT](state, discount) {
        state.discounts.push(discount)
    },

    [types.EDIT_DISCOUNT](state, {index, discount}) {
        state.discounts[state.discounts.findIndex(discount => discount.id)] = discount
    },

    // Delete Discount From State by id
    [types.DELETE_DISCOUNT](state, index) {
        state.discounts = state.discounts.filter(discount => discount.id !== index)
    }
}

const actions = {
    async addDiscount({commit}, form) {
        let data = await form.post('/api/discount')
            .then(data => {
                return data
            })

        commit(types.ADD_DISCOUNT, data)
    },

    async updateDiscount({commit}, {form, index}) {
        let discount = await form.put('/api/discount/' + index)
            .then(discount => {
                return discount
            })

        commit(types.EDIT_DISCOUNT, {index, discount})
    },

    deleteDiscount({commit}, index) {
        axios.delete('/api/discount/' + index)
            .then(discount => {
                return discount
            })

        commit(types.DELETE_DISCOUNT, index)
    },

    async fetchDiscounts({commit}) {
        let data = await axios.get('/api/discount')
            .then(response => {

                return response.data
            })

        commit(types.FETCH_DISCOUNT, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
