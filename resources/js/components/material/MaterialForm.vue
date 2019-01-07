<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Bahan-bahan</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/material">Manajemen Bahan</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Form Bahan - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Form Bahan</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card pt-4 mr-1">
                            <el-form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                     label-position="top" ref="form" :model=form :rules=rules>
                                <el-row :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Name" prop="name">
                                            <el-input size="medium"
                                                      placeholder="Contoh: Makanan Ringan"
                                                      v-model="form.name"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Pemasok" prop="supplier">
                                            <el-input size="medium"
                                                      placeholder="Contoh: PT. Contoh"
                                                      v-model="form.supplier"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Kuantitas & Unit" prop="quantity">
                                            <el-input placeholder="Please input" v-model="form.quantity"
                                                      class="input-with-select" size="medium">
                                                <el-select v-model="form.unit" slot="append" placeholder="Select">
                                                    <el-option label="Kg" value="kg"></el-option>
                                                    <el-option label="Pack" value="pack"></el-option>
                                                    <el-option label="Biji" value="biji"></el-option>
                                                </el-select>
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Tanggal Pembelian">
                                            <el-date-picker
                                                v-model="form.purchase_date"
                                                type="date"
                                                placeholder="Pilih tanggal"
                                                :picker-options="pickerOptions1"
                                                size="medium" style="margin-top: 2px"
                                                class="w-100"
                                                value-format="yyyy-MM-dd">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="24">
                                        <el-form-item size="medium" class="mb-0">
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
        name: "MaterialForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true
                let material = this.getById(parseInt(this.$route.params.id))[0]

                this.form = new Form({
                    name: material.name,
                    unit: material.unit,
                    quantity: material.quantity,
                    purchase_date: material.purchase_date,
                    supplier: material.supplier
                })
            }
        },
        data() {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    unit: 'Kg',
                    quantity: '',
                    purchase_date: '',
                    supplier: ''
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                },
                isLoading: false,
                pickerOptions1: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    },
                    shortcuts: [{
                        text: 'Hari ini',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: 'Kemarin',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: 'Satu minggu yang lalu',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                },
            }
        },
        methods: {
            submit() {
                this.isLoading = true
                this.$store.dispatch('material/addMaterial', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Material Created!')
                    router.push({name: 'material.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('material/updateMaterial', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Material Updated!')
                    router.push({name: 'material.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            },
            ...mapGetters({
                getById: 'material/getById'
            })
        },
    }
</script>

<style>
    .el-select .el-input {
        width: 110px;
    }

    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }
</style>
