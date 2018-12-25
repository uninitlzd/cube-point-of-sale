import axios from 'axios'

const types = {
    FETCH_MEMBER: 'FETCH_MEMBER',
    ADD_MEMBER: 'ADD_MEMBER',
    EDIT_MEMBER: 'EDIT_MEMBER',
    DELETE_MEMBER: 'DELETE_MEMBER'
}

const state = {
    members: [],
}

const getters = {
    getMembers: state => state.members,
    getById: state => index => state.members.filter(member => member.id === index)
}

const mutations = {
    [types.FETCH_MEMBER](state, members) {
        state.members = members
    },

    [types.ADD_MEMBER](state, member) {
        state.members.unshift(member)
    },

    [types.EDIT_MEMBER](state, {index, member}) {
        state.members[index] = member
    },

    // Delete Member From State by id
    [types.EDIT_MEMBER](state, index) {
        state.members = state.members.filter(member => member.id !== index)
    }
}

const actions = {
    async addMember({commit}, form) {
        let data = await form.post('/api/member')
            .then(data => {
                return data
            })

        commit(types.ADD_MEMBER, data)
    },

    async updateMember({commit}, {form, index}) {
        let member = await form.put('/api/member/' + index)
            .then(member => {
                return member
            })

        commit(types.EDIT_MEMBER, {index, member})
    },

    deleteMember({commit}, index) {
        axios.delete('/api/member/' + index)
            .then(member => {
                return member
            })

        commit(types.EDIT_MEMBER, index)
    },

    async fetchMembers({commit}) {
        let data = await axios.get('/api/member')
            .then(response => {

                return response.data
            })

        console.log(data)

        commit(types.FETCH_MEMBER, data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
