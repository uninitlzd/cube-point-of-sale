import axios from 'axios'

const types = {
    FETCH_MATERIAL: 'FETCH_MATERIAL',
    ADD_MATERIAL: 'ADD_MATERIAL',
    EDIT_MATERIAL: 'EDIT_MATERIAL',
    DELETE_MATERIAL: 'DELETE_MATERIAL'
}

const state = {
    materials: [],
}

const getters = {
    getMaterials: state => state.materials,
    getById: state => index => state.materials.filter(material => material.id === index)
}

const mutations = {
    [types.FETCH_MATERIAL](state, materials) {
        state.materials = materials
    },

    [types.ADD_MATERIAL](state, material) {
        state.materials.unshift(material)
    },

    [types.EDIT_MATERIAL](state, {index, material}) {
        state.materials[state.materials.findIndex(material => material.id === index)] = material
    },

    // Delete Material From State by id
    [types.DELETE_MATERIAL](state, index) {
        state.materials = state.materials.filter(material => material.id !== index)
    }
}

const actions = {
    async addMaterial({commit}, form) {
        let data = await form.post('/api/material')
            .then(data => {
                return data
            })

        commit(types.ADD_MATERIAL, data)
    },

    async updateMaterial({commit}, {form, index}) {
        let material = await form.put('/api/material/' + index)
            .then(material => {
                return material
            })

        commit(types.EDIT_MATERIAL, {index, material})
    },

    deleteMaterial({commit}, index) {
        axios.delete('/api/material/' + index)
            .then(material => {
                return material
            })

        commit(types.DELETE_MATERIAL, index)
    },

    async fetchMaterials({commit}) {
        let data = await axios.get('/api/material')
            .then(response => {

                return response.data
            })

        console.log(data)

        commit(types.FETCH_MATERIAL, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
