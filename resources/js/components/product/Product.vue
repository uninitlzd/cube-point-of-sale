<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Produk</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/product">Manajemen Produk</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari Produk" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="primary" icon="el-icon-plus" round size="medium"
                                                   @click="toCreatePage">Produk Baru
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="products"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters"
                                         :total="products.length">
                                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                 :key="title.label">
                                    <template slot-scope="scope">
                                        <div v-if="['purchase_price', 'selling_price'].includes(title.prop)">
                                            <span v-if="title.prop === 'selling_price'">
                                                <span v-if="(scope.row['has_discount'])">Rp{{ scope.row['original_selling_price'] }}</span>
                                                <span v-else>Rp{{ scope.row['selling_price'] }}</span>
                                            </span>
                                            <span v-else>
                                                <span>Rp{{ scope.row[title.prop] }}</span>
                                            </span>
                                        </div>
                                        <div v-else-if="title.prop === 'action'">
                                            <el-dropdown size="small" split-button type="primary" trigger="click" class="" @click="toSetStock(scope.row.id)">
                                                Set Stok
                                                <el-dropdown-menu slot="dropdown">
                                                    <el-dropdown-item @click.native="toEdit(scope.row.id)">Edit</el-dropdown-item>
                                                    <el-dropdown-item @click.native="deleteDiscount(scope.row.id)">Delete</el-dropdown-item>
                                                </el-dropdown-menu>
                                            </el-dropdown>
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
        prop: "name",
        label: "Nama"
    }, {
        prop: "purchase_price",
        label: "Harga Beli"
    }, {
        prop: "selling_price",
        label: "Harga Jual"
    }, {
        prop: "action",
        label: "Action"
    }]

    export default {
        name: "Product",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('product/fetchProducts')
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
                this.$router.push({name: 'product.stock', params: {id}})
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
            ...mapState({
                products: state => state.product.products
            })
        }
    }
</script>

<style scoped>

</style>
