<template xmlns="http://www.w3.org/1999/html">
    <dashboard-shell>
        <el-col :span="24" class="pr-0 mb-0" style="width: calc(100% - 60px)">
            <div class="w-100 h-100 px-4 pt-4">
                <el-row>
                    <el-col :span="16">
                        <el-card class="box-card product-list__wrapper" shadow="never"
                                 style="border-right: none; border-top-right-radius: 0"
                                 :body-style="{ padding: '0px 5px' }">
                            <div slot="header">
                                <el-row :gutter="10">
                                    <el-col class="col-md-8" style="overflow: hidden">
                                        <vue-glide class="w-100">
                                            <vue-glide-slide v-for="i in 10" :key="i" class="mb-0">
                                                <el-button type="primary" class="w-100" size="small">Semua Produk</el-button>
                                            </vue-glide-slide>
                                        </vue-glide>
                                    </el-col>
                                    <el-col class="col-md-4">
                                        <el-input prefix-icon="el-icon-search" placeholder="Cari Produk" size="small" class="input-with-select">

                                        </el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <el-col :span="24" class="pb-3">
                                <el-row>
                                    <el-scrollbar class="scrollbar-component" style="height: calc(100vh - 158px)">
                                        <el-row :gutter="20" class="flex-grow-1 px-3 pl-3 pt-3 pb-0 align-items-top">
                                            <el-col v-for="index in 20" :key="index" class="mb-3 col-md-3 col-sm-6">
                                                <div class="product-list__item">
                                                    <img src="/images/products/20181203035007_products.jpg"
                                                         style="width: 100%; height: 15rem; object-fit: center; object-fit: cover">

                                                    <div class="product-list__item__title w-100 mb-1">
                                                        <p class="mb-0 px-3 py-3">Kopi Kota ya</p>
                                                    </div>
                                                </div>
                                            </el-col>
                                        </el-row>
                                    </el-scrollbar>
                                </el-row>
                            </el-col>
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="box-card order-list__wrapper" shadow="never" style="border-top-left-radius: 0;"
                                 :body-style="{padding: 0}">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col class="col-md-6">Daftar Pesanan</el-col>
                                    <el-col class="col-md-6 text-right">
                                        <el-select v-model="value" placeholder="Tipe Transaksi" size="mini">
                                            <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-col>
                                </el-row>
                            </div>
                            <el-col :span="24" class="d-flex flex-column h-100">
                                <el-row :gutter="10" class="order-list__content__wrapper">
                                    <el-scrollbar class="scrollbar-component h-100" style="flex: 1 1 auto">

                                    </el-scrollbar>
                                </el-row>
                                <el-row :gutter="10" class="pb-2 order-list__button border-top">
                                    <div class="py-2 px-4 ">
                                        <el-col class="col-md-6">
                                            <el-button type="primary">Kembali</el-button>
                                        </el-col>
                                        <el-col class="col-md-6 text-right">
                                            <el-button type="primary">Oke</el-button>
                                        </el-col>
                                    </div>
                                </el-row>
                            </el-col>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
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
    }]

    export default {
        name: "Category",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('category/fetchCategories')
        },
        data() {
            return {
                selectedCategory: [],
                data,
                titles,
                search: '',
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
                            router.push('/category/' + row.id)
                        },
                        label: 'Edit'
                    }, {
                        handler: row => {
                            this.deleteCategory(row.id)
                        },
                        label: 'delete'
                    }]
                },
                options: [{
                    value: 'Regular',
                    label: 'Regular'
                }, {
                    value: 'Member',
                    label: 'Member'
                }, {
                    value: 'Gojek',
                    label: 'Gojek'
                }],
                value: ''
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/category/new')
            },
            deleteCategory(index) {
                store.dispatch('category/deleteCategory', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            }
        },
        computed: {
            ...mapState({
                categories: state => state.category.categories
            })
        }
    }
</script>

<style scoped>

</style>
