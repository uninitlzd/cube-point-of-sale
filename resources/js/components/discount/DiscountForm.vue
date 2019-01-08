<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Member</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/member">Manajemen Member</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Form Member - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Form Member</el-breadcrumb-item>
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
                                        <el-form-item label="Phone" prop="phone">
                                            <el-input size="medium"
                                                      placeholder="Contoh: +6281230909"
                                                      v-model="form.phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row :gutter="10">
                                    <el-col :span="24">
                                        <el-form-item label="Phone" prop="phone">
                                            <el-input type="textarea" size="medium"
                                                      placeholder="Contoh: Tegalsari, Surabaya"
                                                      v-model="form.address"></el-input>
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

    export default {
        name: "EmployeeForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true
                this.$store.dispatch('member/getById', this.$route.params.id).then(member => {
                    console.log(member)
                    this.form = new Form({
                        name: member.name,
                        address: member.address,
                        phone: member.phone,
                        shop_id: member.shop_id
                    })
                })
            }

            this.form.shop_id = this.user.shop.id
        },
        data() {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    phone: '',
                    address: ''
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
            }
        },
        methods: {
            submit() {
                this.isLoading = true
                this.$store.dispatch('member/addMember', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Member Created!')
                    this.$router.push({name: 'member.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('member/updateMember', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Member Updated!')
                    this.$router.push({name: 'member.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            ...mapActions({
                getById: 'member/getById'
            })
        },
        computed: {
            isDisabled() {
                return this.form.incompleted() || this.isLoading
            },
            ...mapGetters({
                user: 'auth/getUser'
            })
        },
    }
</script>

<style scoped>

</style>
