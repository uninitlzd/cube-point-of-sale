<template>
    <dashboard-shell>
        <el-col :span=24 class="">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row type="flex" class="h-100 mr-4" v-if="(shop.shop === null || shop.shop === undefined || editMode)"
                        v-cloak>
                    <el-col :md="12" :sm="24" :sm-offset="0" class="align-self-center mx-auto ">
                        <section class="pl-4 pt-4 text-center">
                            <div class="mb-4">
                                <i class="material-icons text-primary" style="font-size: 6em">store</i>
                                <h4 class="mb-0">Atur Nama Bisnis Anda</h4>
                                <small class="text-black-50"><i>contoh: Kedai Kopi Medan, Toko Bakmi Sederhana</i>
                                </small>
                            </div>
                            <el-form @submit.prevent="submit"
                                     @keydown="form.errors.clear($event.target.name)"
                                     :rules=rules
                                     :model=form
                                     label-position="left">
                                <el-row :gutter=10>
                                    <el-col :md=8 :sm="24">
                                        <el-form-item prop="name" label="Nama Usaha">
                                            <el-input size="medium" placeholder="Name" v-model="form.name" class="align-middle"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md=8 :sm="24">
                                        <el-form-item prop="type" label="Jenis Usaha">
                                            <el-select v-model="form.type" placeholder="Business Type" class="w-100 align-middle"
                                                       size="medium">
                                                <el-option
                                                    v-for="item in types"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :md="8" :sm="24">
                                        <el-form-item prop="tax" label="Presentase PPn">
                                            <el-input label="Presentase PPn" size="medium" placeholder="PPn" v-model="form.tax">
                                                <template slot="append">%</template>
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter=10>
                                    <el-col :span=24>
                                        <el-form-item size="medium">
                                            <el-button type="primary" @click="editMode = false">Cancel
                                            </el-button>
                                            <el-button type="primary" @click="submit">Save
                                            </el-button>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-form>
                        </section>
                    </el-col>
                </el-row>
                <el-row type="flex" class="h-100" v-else v-cloak>
                    <el-col :span=11 :offset=6 class="align-self-center">
                        <section class="pl-4 pt-4 text-center">
                            <div class="mb-3">
                                <i class="material-icons text-primary" style="font-size: 6em">store</i>
                                <h4 class="mb-4">{{ shop.shop.name }}</h4>
                                <small><i></i></small>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <el-button type="primary" icon="el-icon-edit" @click="toEditPage">Ubah Info Bisnis
                                        </el-button>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </el-col>
                </el-row>
            </el-scrollbar>
        </el-col>
    </dashboard-shell>
</template>

<script>
    import DashboardShell from "./DashboardShell";
    import {mapState, mapGetters} from 'vuex'
    import Form from '../utils/Form'

    export default {
        name: "Dashboard",
        components: {DashboardShell},
        data() {
            return {
                editMode: false,
                types: [
                    {id: 1, name: 'Retail'},
                    {id: 2, name: 'Makanan dan Minuman'}
                ],
                form: new Form({
                    name: '',
                    type: '',
                    tax: 0
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input Merchant Name', trigger: 'blur'},
                    ],
                    type: [
                        {required: true, message: 'Please input Business type', trigger: 'blur'},
                    ],
                }
            }
        },
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            submit() {
                this.$store.dispatch('shop/updateShop', this.form)
                    .then(() => {
                        this.$message.success('Save succeed!')
                        this.editMode = false
                    })
                    .catch(error => {
                        this.isLoading = false
                        this.$message.error('Save Failed!')
                    })
            },
            ...mapGetters(['shop/getShop']),
            toEditPage() {
                this.editMode = true
                this.form = new Form({
                    name: this.shop.shop.name,
                    type: parseInt(this.shop.shop.type),
                    tax: parseInt(this.shop.shop.tax),
                })
            }
        },
        computed: {
            ...mapState(['auth', 'shop'])
        }
    }
</script>

<style scoped>

</style>
