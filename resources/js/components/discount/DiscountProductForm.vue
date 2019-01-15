<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :md="23" :xs="24" class="py-4">
                        <h2 class="mb-3">{{ discount.name }}</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/discount">Manajemen Diskon</el-breadcrumb-item>
                            <el-breadcrumb-item>Set Produk</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card mr-5">
                            <div slot="header" class="clearfix">
                                <el-row :gutter="10">
                                    <el-col :span="6">
                                        <el-input placeholder="Cari Produk" class="mr-4" prefix-icon="el-icon-search"
                                                  v-model="filters[0].value"></el-input>
                                    </el-col>
                                    <el-col :span="18" class="text-right">
                                        <el-button type="success" icon="el-icon-check" @click="saveSelection">Simpan
                                            Pilihan
                                        </el-button>
                                    </el-col>
                                </el-row>
                            </div>
                            <data-tables :data="products"
                                      :pagination-props="{background: true, pageSizes: [5, 10, 15] }"
                                      :total="products.length"
                                      @selection-change="handleSelectionChange"
                                      @current-change="handleCurrentChange"
                                      ref="productTable">
                                <el-table-column type="selection" :reserve-selection=true row-key="id"></el-table-column>
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
    import {mapState, mapGetters} from 'vuex'
    import router from '../../router'
    import store from '../../store'
    import Form from '../../utils/Form'

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
    }]

    export default {
        name: "DiscountProductForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                let id = this.$route.params.id
                this.editMode = true
                let discount = this.getById(id)

                this.discount = {
                    id: discount.id,
                    name: discount.name
                }

                axios.get(`/api/product?filter[discount_id]=${id},nullapp`).then(products => {
                    this.products = products.data
                    if (this.products.length === this.products.filter(product => product.has_discount).size) {
                        this.$refs.productTable.$children[0].toggleAllSelection()
                    } else {
                        this.toggleSelection(this.products.filter(product => product.has_discount))
                    }
                })
            }
        },
        mounted() {

        },
        data() {
            return {
                products: [],
                editMode: false,
                discount: {},
                form: new Form({
                    name: '',
                    percentage: '',
                }),
                data,
                titles,
                filters: [
                    {
                        prop: 'name',
                        value: ''
                    }
                ],
                selectedProducts: []
            }
        },
        methods: {
            toCreatePage() {
                this.$router.push('/product/new')
            },
            deleteProduct(index) {
                store.dispatch('product/deleteProduct', index)
                    .then(() => {
                        this.$message.success('Delete Succeed!')
                    }).catch(error => {
                    this.$message.error('Delete Failed!')
                })
            },
            saveSelection() {
                axios.post(`/api/discount/${this.discount.id}/products`, {
                    product_ids: this.selectedProducts.map(product => product.id)
                }).then(response => {
                    this.$router.push({name: 'discount.index'})
                })
            },
            handleSelectionChange(val) {
                this.selectedProducts = val
            },
            handleCurrentChange(val) {
                this.selectedProducts = val
            },
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.productTable.$children[0].toggleRowSelection(row);
                        this.$refs.productTable.$children[0].doLayout()
                    });
                }
            },

        },
        computed: {
            ...mapGetters({
                user: 'auth/getUser',
                getById: 'discount/getById'
            })
        }
    }
</script>

<style scoped>

</style>
