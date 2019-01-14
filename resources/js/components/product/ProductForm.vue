<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Produk</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/product">Manajemen Produk</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Form Produk - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Form Produk</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card pt-4 mr-1">
                            <el-form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                     label-position="top" ref="form" :model=form :rules=rules>
                                <el-row :gutter="20">
                                    <el-col :span="18">
                                        <el-row :gutter="10">
                                            <el-col :span="12">
                                                <el-form-item label="Nama Produk" prop="name">
                                                    <el-input size="medium"
                                                              placeholder="Contoh: Makanan Ringan"
                                                              v-model="form.name"></el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Kategori" prop="category">
                                                    <el-select v-model="form.category_id" filterable placeholder="Select"
                                                               class="w-100">
                                                        <el-option
                                                            v-for="item in categories"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="10">
                                            <el-col :span="12">
                                                <el-form-item label="Harga Beli" prop="purchase_price">
                                                    <el-input placeholder="Please input" v-model="form.purchase_price">
                                                        <template slot="prepend">Rp</template>
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-form-item label="Harga Jual" prop="selling_price">
                                                    <el-input placeholder="Please input" v-model="form.selling_price">
                                                        <template slot="prepend">Rp</template>
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                        <el-row :gutter="10">
                                            <el-col :span="24">
                                                <el-form-item label="Deskripsi" prop="description">
                                                    <el-input
                                                        type="textarea"
                                                        :autosize="{ minRows: 5, maxRows: 8}"
                                                        placeholder="Masukkan deskripsi produk"
                                                        v-model="form.description">
                                                    </el-input>
                                                </el-form-item>
                                            </el-col>
                                        </el-row>
                                    </el-col>
                                    <el-col :span="6">
                                        <el-form-item label="Product Image" prop="category">
                                            <div class="aspectRatioSizer mb-2">
                                                <svg viewBox="0 0 1 1"></svg>
                                                <img :src="imagePreview" alt="" :class=imageFit>
                                            </div>
                                            <input type="file" style="display: none" ref="fileExplorer" @change="setImgPreview">
                                            <el-button type="primary" @click.native="openFileExplorer" size="small">Choose Image</el-button>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="24">
                                        <el-form-item size="medium" class="mb-0">
                                            <input type="hidden" v-model="form.shop_id" ref="shopId">
                                            <el-button v-if=editMode type="primary" @click="update"
                                                       :disabled=isDisabled>Save
                                            </el-button>
                                            <el-button v-else type="primary" @click="submit" :disabled=isDisabled>Submit
                                            </el-button>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-form>
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
    import Form from '../../utils/Form'
    import router from '../../router'

    export default {
        name: "CategoryForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true
                let product = this.getById(parseInt(this.$route.params.id))[0]

                this.imagePreview = product.image

                this.form = new Form({
                    name: product.name,
                    category_id: product.category_id,
                    purchase_price: product.purchase_price,
                    selling_price: (product.has_discount) ? product.original_selling_price : product.selling_price,
                    description: product.description,
                    stockable: 1,
                    image: '',
                    shop_id: product.shop_id
                })
            }

            this.form.shop_id = this.user.shop.id
        },
        data() {
            return {
                editMode: false,
                imagePreview: '/images/no-image-fallback.jpg',
                form: new Form({
                    name: '',
                    category_id: '',
                    purchase_price: '',
                    selling_price: '',
                    description: '',
                    stockable: 1,
                    image: '',
                    shop_id: ''
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                    address: [
                        {required: true, message: 'Please input address', trigger: 'blur'},
                    ],
                    phone: [
                        {required: true, message: 'Please input phone', trigger: 'blur'},
                    ],
                },
                isLoading: false,
                options: [{
                    value: 'Option1',
                    label: 'Option1'
                }, {
                    value: 'Option2',
                    label: 'Option2'
                }, {
                    value: 'Option3',
                    label: 'Option3'
                }, {
                    value: 'Option4',
                    label: 'Option4'
                }, {
                    value: 'Option5',
                    label: 'Option5'
                }],
                value8: '',
                imageFit: ['image-fluid', 'image-fit-cover']
            }
        },
        methods: {
            submit() {
                this.isLoading = true

                this.$store.dispatch('product/addProduct', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Product Created!')
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('product/updateProduct', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Product Updated!')

                }).catch(error => {
                    console.log(error)
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },
            openFileExplorer() {
                this.$refs.fileExplorer.click()
            },
            setImgPreview(event) {
                var input = event.target;
                if (input.files && input.files[0]) {

                    var reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview = e.target.result;
                        this.form.originalData.image = e.target.result
                        this.form.image = e.target.result
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            },
            ...mapGetters({
                getById: 'product/getById',
                categories: 'category/getCategories',
                user: 'auth/getUser'
            })
        },
    }
</script>

<style scoped>
    .image-fit-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
