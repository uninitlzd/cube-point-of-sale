import axios from 'axios'

const types = {
    FETCH_OUTLET_PRODUCT: 'FETCH_OUTLET_PRODUCT',
    ADD_OUTLET_PRODUCT: 'ADD_OUTLET_PRODUCT',
    EDIT_OUTLET_PRODUCT: 'EDIT_OUTLET_PRODUCT',
    DELETE_OUTLET_PRODUCT: 'DELETE_OUTLET_PRODUCT'
}

const state = {
    products: [],
}

const getters = {
    getOutletProducts: state => state.products,
    getById: state => id => state.products.find(product => product.id === id),
    getStockByOutlet: state => id => state.stocks.filter(stock => stock.shop_outlet_id === id)
}

const mutations = {
    [types.FETCH_OUTLET_PRODUCT](state, products) {
        state.products = products
    },
}

const actions = {
    async fetchOutletProducts({commit}) {
        let data = await axios.get('/api/product', {
            params: {
                include: 'stocks'
            }
        })
            .then(response => {

                return response.data
            })

        commit(types.FETCH_OUTLET_PRODUCT, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
