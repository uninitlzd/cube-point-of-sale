<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3">Pengaturan</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/setting">Pengaturan</el-breadcrumb-item>
                            <el-breadcrumb-item>Akun</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card pt-4 mr-1">
                            <el-form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                     label-position="top" ref="form" :model=form :rules=rules>
                                <el-row :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Nama" prop="name">
                                            <el-input size="medium"
                                                      v-model="form.name"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Email" prop="email">
                                            <el-input size="medium"
                                                      type="email"
                                                      v-model="form.email"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Password" prop="password">
                                            <el-input size="medium"
                                                      type="password"
                                                      v-model="form.password"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Konfirmasi Password" prop="password_confirmation">
                                            <el-input size="medium"
                                                      type="password"
                                                      v-model="form.password_confirmation"></el-input>
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
        name: "Setting",
        components: {DashboardShell},
        created() {
            this.form = new Form({
                name: this.user.name,
                email: this.user.email
            })
        },
        data() {
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.form.password) {
                    callback(new Error('Two inputs don\'t match!'));
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
                    password_confimation: ''
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                    email: [
                        {required: true, message: 'Please input email', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: 'Please input password', trigger: 'blur'}
                    ],
                    password_confirmation: [
                        {required: true, validator: validatePass, trigger: 'blur'},
                    ]
                },
                isLoading: false,
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
            ...mapState({
                user: state => state.auth.user
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
