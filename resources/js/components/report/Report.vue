<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Laporan</h2>
                        <el-breadcrumb separator="/" class="mb-3">
                            <el-breadcrumb-item to="/material">Laporan Penjualan</el-breadcrumb-item>
                        </el-breadcrumb>
                    </el-col>
                </el-row>
                <el-row :gutter="10" class="ml-5 mt-4 mr-4">
                    <el-col :span="6">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 14px;">
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col :span="18">
                                        <h6 class="font-weight-bold">Paling Banyak Terjual</h6>
                                        <span v-if="incomeReportSummary.most_selling">{{ incomeReportSummary.most_selling.name }}</span>
                                        <span v-else>-</span>
                                    </el-col>
                                    <el-col :span="6">
                                        <el-button size="mini" class="text-right" v-if="incomeReportSummary.most_selling">{{ incomeReportSummary.most_selling.quantity_sum }}</el-button>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="6">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 14px;">
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col :span="18">
                                        <h6 class="font-weight-bold">Paling Sedikit Terjual</h6>
                                        <span>{{ incomeReportSummary.least_selling.name }}</span>
                                    </el-col>
                                    <el-col :span="6">
                                        <el-button size="mini" class="text-right">{{ incomeReportSummary.least_selling.quantity_sum }}</el-button>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="6">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 14px;">
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col :span="18">
                                        <h6 class="font-weight-bold">Total Keuntungan Kotor</h6>
                                        <span>Rp{{ incomeReportSummary.total_gross_profit }}</span>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="6">
                        <el-card :body-style="{ padding: '0px' }">
                            <div style="padding: 14px;">
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col :span="18">
                                        <h6 class="font-weight-bold">Total Produk Terjual</h6>
                                        <span>{{ incomeReportSummary.total_product_sold }} Produk</span>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
                <el-row :gutter="10" class="ml-5 mr-4">
                    <el-col :md="12" :xs="24" class="py-4">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <h6>Grafik Pemasukan</h6>
                                    </el-col>
                                </el-row>
                            </div>
                            <ve-line :data="incomeChartData" :settings="incomeChartSetting"></ve-line>
                        </el-card>
                    </el-col>
                    <el-col :md="12" :xs="24" class="py-4">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <h6>Grafik Produk Terjual</h6>
                                    </el-col>
                                </el-row>
                            </div>
                            <ve-line :data="productSoldChartData" :settings="productSoldChartSetting"></ve-line>
                        </el-card>
                    </el-col>
                </el-row>
            </el-scrollbar>
        </el-col>
    </dashboard-shell>
</template>

<script>
    import DashboardShell from "../DashboardShell";
    import {mapState} from 'vuex'
    import router from '../../router'
    import store from '../../store'

    let data;

    data = [
        {
            id: 1,
            name: 'Oke',
            address: 'Oce'
        }
    ]

    const titles = [{
        prop: "id",
        label: "ID"
    }, {
        prop: "name",
        label: "Nama Bahan"
    }, {
        prop: "quantity",
        label: "Kuantitas"
    }, {
        prop: "unit",
        label: "Unit"
    }, {
        prop: "purchase_date",
        label: "Tanggal Belanja"
    }]

    export default {
        name: "Report",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('material/fetchMaterials');
            this.$store.dispatch('report/fetchIncomeReportSummary')
            this.$store.dispatch('report/fetchIncomeReport').then(data => {
                this.incomeChartData.rows = data
                this.productSoldChartData.rows = data
            });
        },
        data() {
            return {
                data,
                titles,
                filters: [
                    {
                        prop: 'name',
                        value: ''
                    }
                ],
                actions: {
                    label: 'Action',
                    props: {
                        align: 'center',
                    },
                    buttons: [{
                        props: {
                            type: 'primary',
                            icon: 'el-icon-edit',
                            size: 'small'
                        },
                        handler: row => {
                            router.push('/material/' + row.id)
                        },
                        label: 'Edit'
                    }, {
                        handler: row => {
                            this.deleteMaterial(row.id)
                        },
                        label: 'delete'
                    }]
                },
                incomeChartData: {
                    columns: ['date', 'total_gross_profit'],
                    rows: []
                },
                incomeChartSetting: {
                    labelMap: {
                        total_gross_profit: 'Gross Profit'
                    }
                },
                productSoldChartData: {
                    columns: ['date', 'total_product_sold'],
                    rows: []
                },
                productSoldChartSetting: {
                    labelMap: {
                        total_product_sold: 'Produk Terjual'
                    }
                }
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/material/new')
            },
            deleteMaterial(index) {
                store.dispatch('material/deleteMaterial', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapState({
                materials: state => state.material.materials,
                incomeReports: state => state.report.incomeReports,
                incomeReportSummary: state => state.report.incomeReportSummary
            })
        }
    }
</script>

<style scoped>

</style>
