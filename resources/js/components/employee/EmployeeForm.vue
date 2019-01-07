<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Karyawan</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/employee">Manajemen Karyawan</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Form Karyawan - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Form Karyawan</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card pt-4 mr-1">
                            <el-form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                     label-position="top" ref="form" :model=form :rules=rules>
                                <el-row :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Name" prop="name">
                                            <el-input size="medium"
                                                      placeholder="Contoh: John Doe"
                                                      v-model="form.name"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Email" prop="email">
                                            <el-input size="medium"
                                                      v-model="form.email"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="8">
                                        <el-form-item label="Outlet" prop="outlet">
                                            <el-select v-model="form.shop_outlet_id" filterable placeholder="Pilih Outlet" class="w-100" size="medium">
                                                <el-option
                                                        v-for="item in outlets"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="Password" prop="password">
                                            <el-input placeholder="Password" v-model="form.password" :type="passwordInputType" class="input-with-select" size="medium">
                                                <el-button slot="append" icon="el-icon-view" @click="togglePasswordVisibility"></el-button>
                                            </el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="Password Confirmation" prop="password_confirmation">
                                            <el-input size="medium"
                                                      placeholder="Password Confirmation"
                                                      type="password"
                                                      v-model="form.password_confirmation"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-form-item size="medium" class="mb-0">
                                    <input type="hidden" v-model="form.shop_id" ref="shopId">
                                    <el-button v-if=editMode type="primary" @click="update" :disabled=isDisabled>Save
                                    </el-button>
                                    <el-button v-else type="primary" @click="submit" :disabled=isDisabled>Submit
                                    </el-button>
                                </el-form-item>
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
    import {mapState, mapGetters, mapActions} from 'vuex'
    import Form from '../../utils/Form'
    import router from '../../router'

    var data, titles

    titles = [{
        prop: "id",
        label: "ID"
    }, {
        prop: "name",
        label: "Name"
    }, {
        prop: "address",
        label: "Address"
    }]

    export default {
        name: "EmployeeForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true
                let employee = this.$store.dispatch('employee/getById', this.$route.params.id)
                    .then(employee => {

                        this.form = new Form({
                            name: employee.name,
                            email: employee.email,
                            shop_id: employee.shop_id,
                            shop_outlet_id: employee.outlet.id
                        })
                    })
            }

            this.form.shop_id = this.user.shop.id

            if (this.outlets == null) {
                this.$store.dispatch('outlet/fetchOutlets')
            }
        },
        data() {
            var validatePassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Masukkan konfirmasi password'));
                } else if (value !== this.form.password) {
                    callback(new Error('Konfirmasi password tidak cocok'));
                } else {
                    callback();
                }
            };

            return {
                editMode: false,
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    shop_outlet_id: '',
                    shop_id: ''
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                    email: [
                        { required: true, message: 'Please input email address', trigger: 'blur' },
                        { type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change'] }
                    ],
                    password: [
                        {required: true, message: 'Masukan password', trigger: 'blur'}
                    ],
                    password_confirmation: [
                        {required: true, validator: validatePassword, trigger: 'blur'}
                    ]
                },
                isLoading: false,
                passwordInputType: 'password'
            }
        },
        methods: {
            submit() {
                this.isLoading = true
                this.$store.dispatch('employee/addEmployee', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Employee Created!')
                    router.push({name: 'employee.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('employee/updateEmployee', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Employee Updated!')
                    router.push({name: 'employee.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },
            togglePasswordVisibility() {
                if (this.passwordInputType === 'password') {
                    this.passwordInputType = 'text'
                } else {
                    this.passwordInputType = 'password'
                }
            },
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            },
            ...mapGetters({
                user: 'auth/getUser',
                outlets: 'outlet/getOutlets'
            }),
        },
    }
</script>

<style scoped>

</style>
