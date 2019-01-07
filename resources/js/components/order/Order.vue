<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Transaksi</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/order">Manajemen Transaksi</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari Transaksi" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="orders"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters"
                                         :action-col="actions"
                                         :total="orders.length">
                                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                 :key="title.label">
                                </el-table-column>
                            </data-tables>
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
        prop: "customer_name",
        label: "Nama Pelanggan"
    }, {
        prop: "total",
        label: "Total Belanja"
    }, {
        prop: "created_at",
        label: "Waktu Transaksi"
    }]

    export default {
        name: "Order",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('order/fetchOrders')
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
                            icon: 'el-icon-view',
                            size: 'small'
                        },
                        handler: row => {
                            this.$message.info('oke')
                        },
                        label: 'Detail Transaksi'
                    }]
                }
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/order/new')
            },
            deleteOrder(index) {
                store.dispatch('order/deleteOrder', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapState({
                orders: state => state.order.orders
            })
        }
    }
</script>

<style scoped>

</style>
