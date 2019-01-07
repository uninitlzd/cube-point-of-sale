<template>
    <el-row type="flex" :gutter="10" class="flex-fill mx-0">
        <el-col :span="16" class="px-0">
            <img src="/images/login-bg.jpg" class="image-fit-cover h-100 w-100" alt="">
        </el-col>
        <el-col :span="8" class="px-4 d-flex flex-column">
            <div class="h-100 d-flex">
                <div class="align-self-center w-100">
                    <h2 class="mb-5">Masuk</h2>
                    <el-form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)"
                             label-position="top" :rules=rules ref="form" :model="form">
                        <el-form-item label="Email" prop="email" :error=formError>
                            <el-input size="medium" placeholder="Email" v-model="form.email" v-on:keyup.enter="login"></el-input>
                        </el-form-item>
                        <el-form-item label="Kata Sandi">
                            <el-input type="password" size="medium" placeholder="Kata Sandi"
                                      v-model="form.password" v-on:keyup.enter="login"></el-input>
                        </el-form-item>
                        <el-row type="flex">
                            <el-col :span="12">
                                <el-form-item size="medium">
                                    <el-button type="primary" @click="login" :disabled=isDisabled>Masuk</el-button>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item size="medium" class="text-right">
                                    <a href="/password/reset">Lupa Kata Sandi?</a>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                    <hr>
                    <div class="w-100 text-center">
                        <p>Belum Punya Akun?
                            <router-link to="/register">Daftar</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </el-col>
    </el-row>
</template>

<script>
    import Form from '../utils/Form'

    export default {
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                }),
                rules: {
                    email: [
                        {required: true, message: 'Please input email', trigger: 'blur'},
                        {type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change']}
                    ],
                },
                isLoading: false
            }
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            },
            formError() {
                return this.form.errors.get('message')
            }
        },
        methods: {
            login() {
                if (this.isDisabled) {
                    return false
                }

                this.isLoading = true
                this.$store.dispatch('auth/login', this.form)
                    .catch(error => {
                        console.log(error)
                        this.isLoading = false
                        this.$message.error('Login Failed!')
                    })
            }
        }
    }
</script>
