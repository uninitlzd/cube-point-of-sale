const types = {
    SET_SHOP: 'SET_SHOP',
}

const state = {
    shop: {},
}

const getters = {
    getShop: state => state.shop
}

const mutations = {
    [types.SET_SHOP](state, shop) {
        state.shop = shop
    }
}

const actions = {
    setShop({commit}, shop) {
        commit(types.SET_SHOP, shop)
    },
    async updateShop({commit}, form) {
        let data = await form.post('/api/shop')
            .then(data => {
                return data
            })

        commit(types.SET_SHOP, data)

        console.log(data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
