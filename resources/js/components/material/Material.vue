<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">Bahan-bahan</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/material">Manajemen Bahan-bahan</el-breadcrumb-item>
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
                                                   @click="toCreatePage">Bahan Baru
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="materials"
                                         :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                         :filters="filters"
                                         :action-col="actions"
                                         :total="materials.length">
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
        name: "Material",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('material/fetchMaterials')
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
                materials: state => state.material.materials
            })
        }
    }
</script>

<style scoped>

</style>
