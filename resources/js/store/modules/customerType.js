import axios from 'axios'

const types = {
    FETCH_CUSTOMER_TYPE: 'FETCH_CUSTOMER_TYPE',
    ADD_CUSTOMER_TYPE: 'ADD_CUSTOMER_TYPE',
    EDIT_CUSTOMER_TYPE: 'EDIT_CUSTOMER_TYPE',
    DELETE_CUSTOMER_TYPE: 'DELETE_CUSTOMER_TYPE'
}

const state = {
    customerTypes: [],
}

const getters = {
    getCustomerTypes: state => state.customerTypes,
    getById: state => index => state.customerTypes.filter(customerType => customerType.id === index)[0]
}

const mutations = {
    [types.FETCH_CUSTOMER_TYPE](state, customerTypes) {
        state.customerTypes = customerTypes
    },

    [types.ADD_CUSTOMER_TYPE](state, customerType) {
        state.customerTypes.unshift(customerType)
    },

    [types.EDIT_CUSTOMER_TYPE](state, {index, customerType}) {
        state.customerTypes[state.customerTypes.findIndex(customerType => customerType.id === index)] = customerType
    },

    // Delete CustomerType From State by id
    [types.DELETE_CUSTOMER_TYPE](state, index) {
        state.customerTypes = state.customerTypes.filter(customerType => customerType.id !== index)
    }
}

const actions = {
    async addCustomerType({commit}, form) {
        let data = await form.post('/api/customer/type')
            .then(data => {
                return data
            })

        commit(types.ADD_CUSTOMER_TYPE, data)
    },

    async updateCustomerType({commit}, {form, index}) {
        let customerType = await form.put('/api/customer/type/' + index)
            .then(customerType => {
                return customerType
            })

        commit(types.EDIT_CUSTOMER_TYPE, {index, customerType})
    },

    deleteCustomerType({commit}, index) {
        axios.delete('/api/customer/type/' + index)
            .then(customerType => {
                return customerType
            })

        commit(types.EDIT_CUSTOMER_TYPE, index)
    },

    async fetchCustomerTypes({commit}) {
        let data = await axios.get('/api/customer/type')
            .then(response => {

                return response.data
            })
        commit(types.FETCH_CUSTOMER_TYPE, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
