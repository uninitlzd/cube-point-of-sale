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
    getOutletProducts: state => shop_outlet_id => state.products.each(product => {
       product.stocks = product.stocks.find(stock.shop_outlet_id === shop_outlet_id)
    }),
    getById: state => id => state.products.find(product => product.id === id),
    getStockByOutlet: state => id => state.stocks.filter(stock => stock.shop_outlet_id === id)
}

const mutations = {
    [types.FETCH_PRODUCT](state, products) {
        state.products = products
    },

    [types.ADD_PRODUCT](state, product) {
        state.products.unshift(product)
    },

    [types.EDIT_PRODUCT](state, {id, product}) {
        state.products[state.products.findIndex(product => product.id === id)] = product
    },

    // Delete Product From State by id
    [types.DELETE_PRODUCT](state, id) {
        state.products = state.products.filter(product => product.id !== id)
    }
}

const actions = {
    async addProduct({commit}, form) {
        console.log(form)
        let data = await form.post('/api/product')
            .then(data => {
                return data
            })

        commit(types.ADD_PRODUCT, data)
    },

    async updateProduct({commit}, {index, form}) {
        let product = await form.put('/api/product/' + index)
            .then(product => {
                return product
            })

        commit(types.EDIT_PRODUCT, {index, product})
    },

    deleteProduct({commit}, id) {
        axios.delete('/api/product/' + id)
            .then(product => {
                return product
            })

        commit(types.DELETE_PRODUCT, id)
    },

    async fetchProducts({commit}) {
        let data = await axios.get('/api/product', {
            params: {
                include: 'stocks'
            }
        })
            .then(response => {

                return response.data
            })

        commit(types.FETCH_PRODUCT, data)
    },

    async updateStock({commit}, {stock}) {
        await axios.patch(`/api/outlet/${stock.shop_outlet_id}/product/${stock.product_id}`, {
            number_of_stock: stock.amount
        }).then(response => {
            return response.data
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
