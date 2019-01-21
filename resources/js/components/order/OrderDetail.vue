<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Detail Transaksi</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/order">Manajemen Transaksi</el-breadcrumb-item>
                            <el-breadcrumb-item>Order No. # {{ this.$route.params.id }}</el-breadcrumb-item>
                        </el-breadcrumb>
                        <div class="row">
                            <div class="col-md-4">
                                <el-card class="box-card">
                                    <h6 slot="header" class="mb-0">Pembayaran</h6>
                                    <div>
                                        <p>Total Belanja</p>
                                        <h6 >{{ order.total}}</h6>
                                    </div>
                                </el-card>
                            </div>
                            <div class="col-md-8">
                                <el-card class="box-card mr-5">
                                    <h6 slot="header" class="mb-0">Produk</h6>
                                    <data-tables :data="order.order_details"
                                                 :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                                 :filters="filters"
                                                 :total="order.order_details.length">
                                        <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                         :key="title.label">
                                            <template slot-scope="scope">
                                                <div v-if="['selling_price'].includes(title.prop)">
                                            <span v-if="title.prop === 'selling_price'">
                                                <span>Rp{{ scope.row['selling_price'] }}</span>
                                            </span>
                                                </div>
                                                <div v-else>
                                                    <span>{{ scope.row[title.prop] }}</span>
                                                </div>
                                            </template>
                                        </el-table-column>
                                    </data-tables>
                                </el-card>
                            </div>
                        </div>
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
        prop: "product_name",
        label: "Nama Product"
    }, {
        prop: "quantity",
        label: "Kuantitas"
    }, {
        prop: "selling_price",
        label: "Harga Jual"
    }]

    export default {
        name: "OrderDetail",
        components: {DashboardShell},
        created() {
            axios.get(`/api/order/${this.$route.params.id}?include=details,customer_type`)
                .then(response => {
                    this.order = response.data
                })
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
                order: {
                    order_details: []
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
