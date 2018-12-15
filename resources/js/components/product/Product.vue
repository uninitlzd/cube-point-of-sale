<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row type="flex">
                    <el-col :span="23" class="px-4 py-4">
                        <h2 class="mb-3">Product</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/product">Product Management</el-breadcrumb-item>
                            <el-breadcrumb-item>Product list</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Search Content" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="primary" icon="el-icon-plus" round>New Product</el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables-server :data="products" class="" :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                                :filters="filters" :total="total" @query-change="loadData">
                                <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label"
                                                 :key="title.label">
                                </el-table-column>
                            </data-tables-server>
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

    var data, titles

    titles = [{
        prop: "id",
        label: "ID"
    }, {
        prop: "name",
        label: "Name"
    }, {
        prop: "price",
        label: "Price"
    }, {
        prop: "quantity",
        label: "Quantity"
    }]

    export default {
        name: "Product",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('getProducts')
        },
        data() {
            return {
                data: [],
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
            async loadData(queryInfo) {
                this.$store.dispatch('getProducts', queryInfo)
            }
        },
        computed: {
            ...mapState({
                products: state => state.product.products,
                total: state => state.product.total
            })
        }
    }
</script>

<style scoped>

</style>
