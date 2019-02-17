<template xmlns="http://www.w3.org/1999/html">
    <dashboard-shell :shop_outlet_id="shop_outlet_id">
        <el-col :span="24" class="pr-0 mb-0 mx-auto" style="width: calc(100% - 60px)">
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
                                                <el-button type="primary" :plain="(category !== 0)" class="w-100"
                                                           size="small" @click.native="category = 0">Semua Produk
                                                </el-button>
                                            </vue-glide-slide>
                                            <vue-glide-slide v-for="c in categories" :key="c.id"
                                                             class="mb-0">
                                                <el-button type="primary" :plain="(category !== c.id)" class="w-100"
                                                           size="small" @click.native="category = c.id">{{
                                                    c.name }}
                                                </el-button>
                                            </vue-glide-slide>
                                        </vue-glide>
                                    </el-col>
                                    <el-col class="col-md-4">
                                        <el-input prefix-icon="el-icon-search" placeholder="Cari Produk" size="small"
                                                  class="input-with-select" v-model="searchProduct">
                                        </el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <el-col :span="24" class="pb-3">
                                <el-row>
                                    <el-scrollbar class="scrollbar-component" style="height: calc(100vh - 158px)">
                                        <div v-if="active_shop_outlet_id !== 0"
                                             class="d-flex flex-row flex-wrap flex-grow-1 px-3 pl-3 pt-3 pb-0 align-items-top">
                                            <div
                                                    v-for="product in (searchProduct.length) ? filteredProducts.filter(p => p.name.includes(searchProduct)) : filteredProducts"
                                                    :key="product.id"
                                                    class="d-flex mb-3 col-md-4 col-sm-6">
                                                <div class="product-list__item" @click="addProductOrder(product)"
                                                     v-if="product.stocks.find(stock => stock.shop_outlet_id === active_shop_outlet_id).amount !== 0">
                                                    <img :src=product.image
                                                         style="width: 100%; height: 15rem; object-fit: cover; object-fit: cover">

                                                    <div class="product-list__item__title w-100 mb-1">
                                                        <p class="mb-0 px-3 py-3">{{ product.name }}</p>
                                                    </div>
                                                </div>
                                                <div class="product-list__item" v-else style="opacity: 0.5;">
                                                    <img :src=product.image
                                                         style="width: 100%; height: 15rem; object-fit: cover; object-fit: cover">

                                                    <div class="product-list__item__title w-100 mb-1">
                                                        <p class="mb-0 px-3 py-3">{{ product.name }} (Habis)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="d-flex h-100">
                                            <h5 class="align-self-center mx-auto">Pilih Outlet Terlebih Dahulu</h5>
                                        </div>
                                    </el-scrollbar>
                                </el-row>
                            </el-col>
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="box-card order-list__wrapper" shadow="never" style="border-top-left-radius: 0;"
                                 :body-style="{padding: 0}">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10" class="d-flex align-items-center mb-2">
                                    <el-col class="col-md-6 font-weight-bold"><span>Daftar Pesanan</span></el-col>
                                    <el-col class="col-md-6 text-right">
                                        <el-select v-model="orders.type" placeholder="Tipe Transaksi" size="mini"
                                                   @change="memberTypeOnChange(orders.type)">
                                            <el-option
                                                    v-for="type in customerTypes"
                                                    :key="type.id"
                                                    :label=type.name
                                                    :value="type.id">
                                                <span>{{ type.name }} ({{ type.discount_percentage }}%)</span>
                                            </el-option>
                                        </el-select>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10" class="d-flex align-items-center">
                                    <el-col class="col-md-6 font-weight-bold"><span>Nama Pelanggan:</span></el-col>
                                    <el-col class="col-md-6 text-right">
                                        <el-input size="mini" v-model="orders.customerName" placeholder="Nama"
                                                  v-if="orders.type === 1"></el-input>
                                        <el-select
                                                v-else
                                                v-model="orders.member_id"
                                                filterable
                                                reserve-keyword
                                                placeholder="Cari member"
                                                size="mini">
                                            <el-option
                                                    v-for="item in members"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </el-col>
                                </el-row>
                            </div>
                            <el-col :span="24" class="d-flex flex-column h-100">
                                <el-row :gutter="10" class="order-list__content__wrapper d-flex px-2">
                                    <el-scrollbar class="scrollbar-component" style="flex: 1 1 auto">
                                        <div class="px-3 py-2">
                                            <div v-for="(product, index) in orders.products" class="my-3"
                                                 v-if="active_shop_outlet_id !== 0">
                                                <el-row type="flex">
                                                    <el-col :md="22">
                                                        <p class="mb-2 font-weight-bold">{{ product.name }} {{
                                                            (product.has_discount) ? '(Promo)' : ''}}</p>
                                                        <el-row type="flex" :gutter="10">
                                                            <el-col class="col-md-4">
                                                                <span>Rp{{ product.selling_price }}</span></el-col>
                                                            <el-col class="col-md-4">
                                                                <el-input-number size="mini" :min="0"
                                                                                 :max="product.stocks.find(stock => stock.shop_outlet_id === active_shop_outlet_id).amount"
                                                                                 class="w-100"
                                                                                 v-model="product.amount"
                                                                                 @change="isZero(product.amount, index)"></el-input-number>
                                                            </el-col>
                                                            <el-col class="col-md-4"><span>Rp{{ product.amount * product.selling_price }}</span>
                                                            </el-col>
                                                        </el-row>
                                                    </el-col>
                                                    <el-col :md="2" class="align-self-center">
                                                        <el-button type="danger" size="mini" circle plain
                                                                   icon="el-icon-close"
                                                                   @click.native="deleteProductOrder(index)"></el-button>
                                                    </el-col>
                                                </el-row>
                                                <hr class="mt-3 mb-3">
                                            </div>
                                            <div v-else class="d-flex h-100">
                                                <h5 class="align-self-center mx-auto">Pilih Outlet Terlebih Dahulu</h5>
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
                                            <el-col :md="8" class="font-weight-bold"><span>Rp{{ orderTotal }}</span>
                                            </el-col>
                                        </el-row>
                                    </div>
                                </el-row>
                                <el-row :gutter="10" class="pb-2 order-list__button border-top no-gutters">
                                    <div class="py-4 px-4 d-flex align-items-center">
                                        <el-col class="col-md-6 px-0">
                                            <el-button type="danger" size="small" circle
                                                       icon="el-icon-delete" @click.native="emptyOrder"></el-button>
                                        </el-col>
                                        <el-col class="col-md-6 text-right">
                                            <el-button type="success" size="small"
                                                       @click.native="paymentProcessDialog = true">Proses
                                            </el-button>
                                        </el-col>
                                    </div>
                                </el-row>
                            </el-col>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </el-col>
        <el-dialog title="Pembayaran" :visible.sync="paymentProcessDialog">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Dibayar</label>
                    <el-input placeholder="Dibayar" v-model="orders.paid" type="number">
                        <template slot="prepend">Rp</template>
                    </el-input>
                </div>
                <div class="col-md-6">
                    <label for="">Total</label>
                    <h2>Rp{{ orders.total }}</h2>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex flex-row flex-wrap align-items-center">
                        <div class="d-flex w-100 flex-wrap my-2">
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(7)">7
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(8)">8
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(9)">9
                            </el-button>
                        </div>
                        <div class="d-flex w-100 flex-wrap my-2">
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(4)">4
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(5)">5
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(6)">6
                            </el-button>
                        </div>
                        <div class="d-flex w-100 flex-wrap my-2">
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(1)">1
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(2)">2
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener(3)">3
                            </el-button>
                        </div>
                        <div class="d-flex w-100 flex-wrap my-2">
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener('0')">0
                            </el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener('del')"><span
                                    class="el-icon-arrow-left"></span></el-button>
                            <el-button type="primary" class="flex-grow-1" plain round
                                       @click.native="nominalButtonListener('clear')">C
                            </el-button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right mt-2">
                    <el-button type="success" @click.native="orderCheckout">Bayar</el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog
                width="30%"
                title="Kembalian"
                :visible.sync="moneyChangePopup"
                v-on:closed="emptyOrderNoDialog">
            <h4>Rp{{ moneyChange }}</h4>
            <div slot="footer" class="dialog-footer">
                <el-button @click="moneyChangePopup = false; paymentProcessDialog = false">Tutup</el-button>
            </div>
        </el-dialog>
    </dashboard-shell>
</template>

<script>
    import DashboardShell from "../DashboardShell";
    import {mapState, mapGetters} from 'vuex'
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
        name: "Cashier",
        components: {DashboardShell},
        created() {
            this.$store.dispatch('category/fetchCategories')
            this.$store.dispatch('product/fetchProducts')
            this.$store.dispatch('customerType/fetchCustomerTypes')
            this.$store.dispatch('member/fetchMembers')

            this.shop_outlet_id = this.active_shop_outlet_id
        },
        data() {
            return {
                selectedCategory: [],
                category: 0,
                shop_outlet_id: 0,
                data,
                titles,
                searchProduct: '',
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
                orders: {
                    type: 1,
                    member_id: '',
                    customerName: '',
                    products: [],
                    tax: '',
                    orderTotal: '',
                    total: '',
                    paid: 0,
                    amount: ''
                },
                paymentProcessDialog: false,
                moneyChangePopup: false,
                nominals: [5000, 10000, 20000, 50000, 100000]
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
                if (this.orders.products.filter(product => product.id === p.id).length !== 0) {
                    this.orders.products = this.orders.products.map(product => {
                        if (product.id === p.id)
                            product.amount += 1

                        return product
                    })
                } else {
                    p.amount = 1
                    this.orders.products.push(p)
                }
            },
            deleteProductOrder(i) {
                this.orders.products = this.orders.products.filter((value, index, arr) => index !== i)
            },
            isZero(productAmount, i) {
                if (productAmount === 0)
                    this.deleteProductOrder(i)

                this.orders.products = this.orders.products.slice()
            },
            emptyOrder() {
                this.$confirm('Anda yakin ingin mengkosongkan daftar order?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.orders.products = []

                    this.$message({
                        type: 'success',
                        message: 'Daftar order dikosongkan'
                    });
                });
            },
            memberTypeOnChange(type) {
                if (type === 1) {
                    this.orders.member_id = ''
                }
            },
            nominalButtonListener(val) {
                switch (val) {
                    case 'del':
                        return this.orders.paid = this.orders.paid.slice(0, -1)
                    case 'clear':
                        return this.orders.paid = ''
                    default:
                        return this.orders.paid += val + ''
                }
            },
            orderCheckout() {
                axios.post('/api/order', {
                    customer_type_id: this.orders.type,
                    member_id: this.orders.member_id,
                    customer_name: this.orders.customerName,
                    shop_outlet_id: this.active_shop_outlet_id,
                    order_details: this.orders.products,
                    order_total: this.orders.orderTotal,
                    tax: this.orders.tax,
                    total: this.orders.orderTotal + this.orders.tax,
                    paid: this.orders.paid,
                    amount: this.orders.amount
                }).then(response => {
                    this.$message.success('Pesanan berhasil diproses')
                    this.paymentProcessDialog = false
                    this.moneyChangePopup = true
                }).catch(response => {
                    this.$message.warning('Pesanan gagal diproses')
                })
            },
            emptyOrderNoDialog() {
                this.orders = {
                    type: 1,
                        member_id: '',
                        customerName: '',
                        products: [],
                        tax: '',
                        orderTotal: '',
                        total: '',
                        paid: 0,
                        amount: ''
                }
            }
        },
        computed: {
            ...mapState({
                categories: state => state.category.categories,
                user: state => state.auth.user,
                customerTypes: state => state.customerType.customerTypes,
                members: state => state.member.members,
                products: state => state.product.products,
                active_shop_outlet_id: state => state.auth.active_shop_outlet_id
            }),
            orderSubTotal() {
                let customerType = this.customerTypes.find(customerType => {
                    return customerType.id === this.orders.type
                })

                let subTotal = this.orders.products.reduce((acc, current, currentIndex, arr) => {
                    return acc + (current.amount * current.selling_price)
                }, 0)

                let amount = this.orders.products.reduce((acc, current, currentIndex, arr) => {
                    return acc + (current.amount)
                }, 0)

                this.orders.amount = amount

                if (customerType.discount_percentage)
                    subTotal *= 1 - customerType.discount_percentage / 100

                this.orders.orderTotal = subTotal
                return subTotal
            },
            orderTax() {
                return this.orders.tax = (this.user.shop.tax / 100) * this.orderSubTotal
            },
            orderTotal() {
                return this.orders.total = this.orderSubTotal + this.orderTax
            },
            filteredProducts() {
                let products = this.products
                if (this.category !== 0) {
                    products = products.filter(product => product.category_id === this.category)
                }

                return products
            },
            moneyChange() {
                return (parseInt(this.orders.paid) - parseInt(this.orderTotal) > 0) ? parseInt(this.orders.paid) - parseInt(this.orderTotal) : 0
            }
        },
        watch: {
            shop_outlet_id() {
                this.$router.push('/cashier')
                this.$forceUpdate()
            }
        }
    }
</script>

<style scoped>

</style>

<!--Todo: Renew newest product information even product has been added in order storage-->
