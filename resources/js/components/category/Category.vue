<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row type="flex">
                    <el-col :span="23" class="px-4 py-4">
                        <h2 class="mb-3">Category</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item>Category Management</el-breadcrumb-item>
                            <el-breadcrumb-item>Category list</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Search Content" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="primary" icon="el-icon-plus" round size="medium" @click="toCreatePage">New Category</el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="data" :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters" :total="data.length">
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

    var data, titles

    data = [
        {
            id: 1,
            name: 'One',
            address: 'Gang'
        }
    ]

    titles = [{
        prop: "id",
        label: "ID"
    }, {
        prop: "name",
        label: "Name"
    }, {
        prop: "address",
        label: "Address"
    }]

    export default {
        name: "Category",
        components: {DashboardShell},
        created() {

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
                this.$router.push('/outlet/new')
            }
        },
        computed: {
        }
    }
</script>

<style scoped>

</style>
