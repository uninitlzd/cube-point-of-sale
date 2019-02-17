import axios from 'axios'

const types = {
    FETCH_INCOME_REPORT: 'FETCH_INCOME_REPORT',
    FETCH_INCOME_REPORT_SUMMARY: 'FETCH_INCOME_REPORT_SUMMARY',
}

const state = {
    incomeReports: [],
    incomeReportSummary: '',
}

const getters = {
    getIncomeReports: state => state.incomeReports,
    getIncomeReportSummary: state => state.incomeReportSummary,
}

const mutations = {
    [types.FETCH_INCOME_REPORT](state, incomeReports) {
        state.incomeReports = incomeReports
    },
    [types.FETCH_INCOME_REPORT_SUMMARY](state, incomeReportSummary) {
        state.incomeReportSummary = incomeReportSummary
    },
}

const actions = {
    async fetchIncomeReport({commit}) {
        let data = await axios.get('/api/report/selling')
            .then(response => {

                return response.data
            })

        commit(types.FETCH_INCOME_REPORT, data)

        return data;
    },
    async fetchIncomeReportSummary({commit}) {
        let data = await axios.get('/api/report/selling/summary')
            .then(response => response.data)

        commit(types.FETCH_INCOME_REPORT_SUMMARY, data)

        return data;
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
}
