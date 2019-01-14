<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">{{ product.name }}</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/product">Manajemen Produk</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari Produk" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="search"></el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="stocks.filter(data => !search || data.outlet.name.toLowerCase().includes(search.toLowerCase()))"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :total="stocks.length">
                                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                 :key="title.label">
                                    <template slot-scope="scope">
                                        <div v-if="title.prop === 'name'">
                                            <span>{{ scope.row['outlet'].name}}</span>
                                        </div>
                                        <div v-else-if="title.prop === 'amount'">
                                            <el-input-number v-model="scope.row['amount']" size="small"></el-input-number>
                                        </div>
                                        <div v-else>
                                            <span>{{ scope.row[title.prop] }}</span>
                                        </div>
                                    </template>
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
    import DashboardShell from "../../DashboardShell";
    import {mapState, mapGetters} from 'vuex'
    import router from '../../../router'
    import store from '../../../store'

    let data;

    data = [
        {
            id: 1,
            name: 'Oke',
            address: 'Oce'
        }
    ]

    const titles = [{
        prop: "name",
        label: "Nama Outlet"
    }, {
        prop: "amount",
        label: "Stok"
    }]

    export default {
        name: "ProductStock",
        components: {DashboardShell},
        created() {

            let id = this.$route.params.id

            axios.get(`/api/product/${id}`, {
                params: {
                    include: 'stocks,stocks.outlet'
                }
            }).then(response => {
                this.product = response.data
                this.stocks = this.product.stocks
            })
        },
        data() {
            return {
                product: '',
                stocks: [],
                data,
                titles,
                search: ''
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/product/new')
            },
            toEdit(id) {
                this.$router.push((`/product/${id}`))
            },
            toSetStock(id) {
                this.$router.push((`/product/${id}/stock`))
            },
            deleteProduct(index) {
                store.dispatch('product/deleteProduct', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapGetters({
                getById: 'product/getById',
                categories: 'category/getCategories',
                user: 'auth/getUser'
            })
        }
    }
</script>

<style scoped>

</style>
