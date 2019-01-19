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
                                        <vue-glide class="w-100" :options="{ gap: 10 }">
                                            <vue-glide-slide class="mb-0">
                                                <el-button type="primary" class="w-100" size="small">Semua Produk
                                                </el-button>
                                            </vue-glide-slide>
                                            <vue-glide-slide v-for="category in categories" :key="category.id"
                                                             class="mb-0">
                                                <el-button type="primary" plain class="w-100" size="small">{{
                                                    category.name }}
                                                </el-button>
                                            </vue-glide-slide>
                                        </vue-glide>
                                    </el-col>
                                    <el-col class="col-md-4">
                                        <el-input prefix-icon="el-icon-search" placeholder="Cari Produk" size="small"
                                                  class="input-with-select">

                                        </el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <el-col :span="24" class="pb-3">
                                <el-row>
                                    <el-scrollbar class="scrollbar-component" style="height: calc(100vh - 158px)">
                                        <el-row :gutter="20" class="flex-grow-1 px-3 pl-3 pt-3 pb-0 align-items-top">
                                            <el-col v-for="product in products" :key="product.id"
                                                    class="mb-3 col-md-3 col-sm-6">
                                                <div class="product-list__item" @click="addProductOrder(product)">
                                                    <img :src=product.image
                                                         style="width: 100%; height: 15rem; object-fit: cover; object-fit: cover">

                                                    <div class="product-list__item__title w-100 mb-1">
                                                        <p class="mb-0 px-3 py-3">{{ product.name }}</p>
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
                                    <el-col class="col-md-6 font-weight-bold"><span>Daftar Pesanan</span></el-col>
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
                                <el-row :gutter="10" class="order-list__content__wrapper d-flex px-2">
                                    <el-scrollbar class="scrollbar-component" style="flex: 1 1 auto">
                                        <div class="px-3 py-2">
                                            <div v-for="(order, index) in orders" class="my-3">
                                                <el-row type="flex">
                                                    <el-col :md="22">
                                                        <p class="mb-2 font-weight-bold">{{ order.name }} {{ (order.has_discount) ? '(Promo)' : ''}}</p>
                                                        <el-row type="flex" :gutter="10">
                                                            <el-col class="col-md-4"><span>Rp{{ order.selling_price }}</span></el-col>
                                                            <el-col class="col-md-4">
                                                                <el-input-number size="mini" :min="0" class="w-100" v-model="order.amount" @change="isZero(order, index)"></el-input-number>
                                                            </el-col>
                                                            <el-col class="col-md-4"><span>Rp{{ order.amount * order.selling_price }}</span></el-col>
                                                        </el-row>
                                                    </el-col>
                                                    <el-col :md="2" class="align-self-center">
                                                        <el-button type="danger" size="mini" circle plain icon="el-icon-close" @click.native="deleteProductOrder(index)"></el-button>
                                                    </el-col>
                                                </el-row>
                                                <hr class="mt-3 mb-3">
                                            </div>
                                        </div>
                                    </el-scrollbar>
                                </el-row>
                                <el-row :gutter="10" class="pb-2 order-list__total border-top">
                                    <div class="py-2 px-4 ">
                                        <el-row type="flex">
                                            <el-col :md="16" class="font-weight-bold" style="font-size: 10pt"><span>Sub Total</span>
                                            </el-col>
                                            <el-col :md="8" class="font-weight-bold" style="font-size: 10pt"><span>Rp{{ orderSubTotal }}</span>
                                            </el-col>
                                        </el-row>
                                        <el-row type="flex">
                                            <el-col :md="16" class="font-weight-bold" style="font-size: 10pt">
                                                <span>Tax</span></el-col>
                                            <el-col :md="8" class="font-weight-bold" style="font-size: 10pt"><span>Rp{{ orderTax }}</span>
                                            </el-col>
                                        </el-row>
                                        <hr class="mt-2 mb-2">
                                        <el-row type="flex">
                                            <el-col :md="16" class="font-weight-bold"><span>Total</span></el-col>
                                            <el-col :md="8" class="font-weight-bold"><span>Rp{{ orderTotal }}</span></el-col>
                                        </el-row>
                                    </div>
                                </el-row>
                                <el-row :gutter="10" class="pb-2 order-list__button border-top no-gutters">
                                    <div class="py-4 px-4 d-flex align-items-center">
                                        <el-col class="col-md-6 px-0">
                                            <el-button type="danger" size="small" circle
                                                       icon="el-icon-delete"></el-button>
                                        </el-col>
                                        <el-col class="col-md-6 text-right">
                                            <el-button type="success" size="small">Proses</el-button>
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
            this.$store.dispatch('product/fetchProducts')
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
                value: '',
                orders: []
            }
        },
        persist: ['orders'],
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
            },
            addProductOrder(p) {
                if (this.orders.filter(product => product.id === p.id).length !== 0) {
                    this.orders.filter(product => product.id === p.id)
                        .map(product => {
                            product.amount += 1
                        })

                    this.orders = this.orders.slice()
                } else {
                    p.amount = 1
                    this.orders.push(p)
                }
            },
            deleteProductOrder(i) {
                this.orders = this.orders.filter((value, index, arr) => index !== i)
            },
            isZero(order, i) {
                if (order.amount === 0)
                    this.deleteProductOrder(i)
            }
        },
        computed: {
            ...mapState({
                categories: state => state.category.categories,
                products: state => state.product.products,
                user: state => state.auth.user
            }),
            orderSubTotal() {
                return this.orders.reduce((acc, current, currentIndex, arr) => {
                    console.log(current)
                    return acc + (current.amount * current.selling_price)
                }, 0)
            },
            orderTax() {
                return (this.user.shop.tax / 100) * this.orderSubTotal
            },
            orderTotal() {
                return this.orderSubTotal + this.orderTax
            }
        }
    }
</script>

<style scoped>

</style>

<!--Todo: Renew newest product information even product has been added in order storage-->
