import axios from 'axios'

const types = {
    FETCH_EMPLOYEE: 'FETCH_EMPLOYEE',
    ADD_EMPLOYEE: 'ADD_EMPLOYEE',
    EDIT_EMPLOYEE: 'EDIT_EMPLOYEE',
    DELETE_EMPLOYEE: 'DELETE_EMPLOYEE'
}

const state = {
    employees: [],
}

const getters = {
    getEmployees: state => state.employees,
    getById: state => index => state.employees.filter(employee => employee.id === index)
}

const mutations = {
    [types.FETCH_EMPLOYEE](state, employees) {
        state.employees = employees
    },

    [types.ADD_EMPLOYEE](state, employee) {
        state.employees.unshift(employee)
    },

    [types.EDIT_EMPLOYEE](state, {index, employee}) {
        state.employees[state.employees.findIndex(employee => employee.id)] = employee
    },

    // Delete Employee From State by id
    [types.DELETE_EMPLOYEE](state, index) {
        state.employees = state.employees.filter(employee => employee.id !== index)
    }
}

const actions = {
    async addEmployee({commit}, form) {
        let data = await form.post('/api/employee')
            .then(data => {
                return data
            })

        commit(types.ADD_EMPLOYEE, data)
    },

    async updateEmployee({commit}, {form, index}) {
        let employee = await form.put('/api/employee/' + index)
            .then(employee => {
                return employee
            })

        commit(types.EDIT_EMPLOYEE, {index, employee})
    },

    deleteEmployee({commit}, index) {
        axios.delete('/api/employee/' + index)
            .then(employee => {
                return employee
            })

        commit(types.DELETE_EMPLOYEE, index)
    },

    async fetchEmployees({commit}) {
        let data = await axios.get('/api/employee')
            .then(response => {

                return response.data
            })

        commit(types.FETCH_EMPLOYEE, data)
    },

    async getById({commit}, id) {
        let data = await axios.get(`/api/employee/${id}`)
            .then(response => {
                if (state.employees.findIndex(employee => employee.id) === -1) {

                    state.employees.push(response.data)
                }
                return response.data
            }).catch(() => {
                return state.employees.findIndex(employee => employee.id)
            })

        return data
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
