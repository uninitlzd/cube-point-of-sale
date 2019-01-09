<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Discount</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/discount">Manajemen Discount</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari Discount" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="primary" icon="el-icon-plus" round size="medium"
                                                   @click="toCreatePage">Discount Baru
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="discounts"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters"
                                         :action-col="actions"
                                         :total="discounts.length">
                                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                 :key="title.label">
                                    <template slot-scope="scope">
                                        <div v-if="title.prop == 'action'">
                                            <el-dropdown size="small" split-button type="primary" trigger="click" class="" @click="toSetProduct(scope.row.id)">
                                                Set Produk
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
        label: "Name"
    }, {
        prop: "percentage",
        label: "Persentase"
    }, {
        prop: "action",
        label: "Action"
    }]

    export default {
        name: "Discount",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('discount/fetchDiscounts')
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
                ]
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/discount/new')
            },
            toEdit(id) {
                this.$router.push((`/discount/${id}`))
            },
            toSetProduct(id) {
                this.$router.push((`/discount/${id}/products`))
            },
            deleteDiscount(index) {
                store.dispatch('discount/deleteDiscount', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapState({
                discounts: state => state.discount.discounts
            })
        }
    }
</script>

<style scoped>

</style>
