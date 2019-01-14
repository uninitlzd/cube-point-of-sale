<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">CustomerType</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/customer-type">Manajemen CustomerType</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari CustomerType" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="primary" icon="el-icon-plus" round size="medium"
                                                   @click="toCreatePage">CustomerType Baru
                                        </el-button>
                                        <el-button type="success" icon="el-icon-menu" round size="medium"
                                                   @click="toCustomerTypePage">Tipe Pelanggan
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="customer-types"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters"
                                         :action-col="actions"
                                         :total="customer-types.length">
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
        prop: "name",
        label: "Name"
    }, {
        prop: "address",
        label: "Address"
    }, {
        prop: "phone",
        label: "Phone"
    }]

    export default {
        name: "CustomerType",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('customer-type/fetchCustomerTypes')
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
                            router.push('/customer-type/' + row.id)
                        },
                        label: 'Edit'
                    }, {
                        handler: row => {
                            this.deleteCustomerType(row.id)
                        },
                        label: 'delete'
                    }]
                }
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/customer-type/new')
            },
            toCustomerTypePage() {
                this.$router.push('/customer-type/')
            },
            deleteCustomerType(index) {
                store.dispatch('customerType/delete', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapState({
                customerType: state => state.customerType.customerTypes
            })
        }
    }
</script>

<style scoped>

</style>
