import axios from 'axios'

const types = {
    FETCH_CATEGORY: 'FETCH_CATEGORY',
    ADD_CATEGORY: 'ADD_CATEGORY',
    EDIT_CATEGORY: 'EDIT_CATEGORY',
    DELETE_CATEGORY: 'DELETE_CATEGORY'
}

const state = {
    categories: [],
}

const getters = {
    getCategories: state => state.categories,
    getById: state => index => state.categories.filter(category => category.id === index)
}

const mutations = {
    [types.FETCH_CATEGORY](state, categories) {
        state.categories = categories
    },

    [types.ADD_CATEGORY](state, category) {
        state.categories.unshift(category)
    },

    [types.EDIT_CATEGORY](state, {index, category}) {
        state.categories[state.categories.findIndex(category => category.id)] = category
    },

    // Delete Category From State by id
    [types.DELETE_CATEGORY](state, index) {
        state.categories = state.categories.filter(category => category.id !== index)
    }
}

const actions = {
    async addCategory({commit}, form) {
        let data = await form.post('/api/category')
            .then(data => {
                return data
            })

        commit(types.ADD_CATEGORY, data)
    },

    async updateCategory({commit}, {form, index}) {
        let category = await form.put('/api/category/' + index)
            .then(category => {
                return category
            })

        commit(types.EDIT_CATEGORY, {index, category})
    },

    deleteCategory({commit}, index) {
        axios.delete('/api/category/' + index)
            .then(category => {
                return category
            })

        commit(types.DELETE_CATEGORY, index)
    },

    async fetchCategories({commit}) {
        let data = await axios.get('/api/category')
            .then(response => {
                return response.data
            })

        console.log(data)

        commit(types.FETCH_CATEGORY, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
