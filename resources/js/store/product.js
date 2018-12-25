import axios from 'axios'

const types = {
    FETCH_PRODUCT: 'FETCH_PRODUCT',
    ADD_PRODUCT: 'ADD_PRODUCT',
    EDIT_PRODUCT: 'EDIT_PRODUCT',
    DELETE_PRODUCT: 'DELETE_PRODUCT'
}

const state = {
    products: [],
}

const getters = {
    getProducts: state => state.products,
    getById: state => index => state.products.filter(product => product.id === index)
}

const mutations = {
    [types.FETCH_PRODUCT](state, products) {
        state.products = products
    },

    [types.ADD_PRODUCT](state, product) {
        state.products.unshift(product)
    },

    [types.EDIT_PRODUCT](state, {index, product}) {
        state.products[index] = product
    },

    // Delete Product From State by id
    [types.EDIT_PRODUCT](state, index) {
        state.products = state.products.filter(product => product.id !== index)
    }
}

const actions = {
    async addProduct({commit}, form) {
        let data = await form.post('/api/product')
            .then(data => {
                return data
            })

        commit(types.ADD_PRODUCT, data)
    },

    async updateProduct({commit}, {form, index}) {
        let product = await form.put('/api/product/' + index)
            .then(product => {
                return product
            })

        commit(types.EDIT_PRODUCT, {index, product})
    },

    deleteProduct({commit}, index) {
        axios.delete('/api/product/' + index)
            .then(product => {
                return product
            })

        commit(types.EDIT_PRODUCT, index)
    },

    async fetchProducts({commit}) {
        let data = await axios.get('/api/product')
            .then(response => {

                return response.data
            })

        console.log(data)

        commit(types.FETCH_PRODUCT, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}