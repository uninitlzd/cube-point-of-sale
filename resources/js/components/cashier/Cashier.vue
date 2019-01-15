<template xmlns="http://www.w3.org/1999/html">
    <dashboard-shell>
        <el-col :span="24" class="pr-0 mb-0">
            <div class="w-100 h-100 px-4 pt-4">
                <el-row>
                    <el-col :span="16">
                        <el-card class="box-card product-list__wrapper" shadow="never" style="border-right: none; border-top-right-radius: 0">
                            <div slot="header" class="clearfix">
                                <span>Daftar Produk</span>
                            </div>
                            <el-col :span="24" class="pb-3">
                                <el-row :gutter="10">
                                    <el-scrollbar class="scrollbar-component" style="height: calc(100vh - 180px)">
                                        <el-col :span="6" v-for="index in 20" :key="index" class="mb-2 pr-4">
                                            <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                                <img src="/images/products/20181203035007_products.jpg" class="image" style="object-fit: cover">
                                                <div style="padding: 14px;">
                                                    <span>Yummy hamburger</span>
                                                    <div class="bottom clearfix">
                                                        <time class="time"></time>
                                                        <el-button type="text" class="button">Operating button</el-button>
                                                    </div>
                                                </div>
                                            </el-card>
                                        </el-col>
                                    </el-scrollbar>
                                </el-row>
                            </el-col>
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="box-card product-list__wrapper" shadow="never" style="border-top-left-radius: 0;" :body-style="{padding: 0}">
                            <div slot="header" class="clearfix">
                                <span>Daftar Pesanan</span>
                            </div>
                            <el-col :span="24" class="pb-3">
                                <div class="h-25 bg-primary w-100"></div>
                                <el-row :gutter="10">
                                    <el-scrollbar class="scrollbar-component" style="height: calc(100vh - 180px)">

                                    </el-scrollbar>
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
                }
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
