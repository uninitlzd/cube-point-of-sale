<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Discount</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/discount">Manajemen Discount</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Form Discount - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Form Discount</el-breadcrumb-item>
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
                                        <el-form-item label="Persentase Diskon" prop="percentage">
                                            <el-input size="medium"
                                                      placeholder="Contoh: 20"
                                                      v-model="form.percentage"></el-input>
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
                let discount = this.getById(this.$route.params.id)
                console.log(discount)
                this.form = new Form({
                    name: discount.name,
                    percentage: discount.percentage,
                })
            }

            this.form.shop_id = this.user.shop.id
        },
        data() {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    percentage: '',
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                    percentage: [
                        {required: true, message: 'Please input percentage', trigger: 'blur'},
                    ],
                },
                isLoading: false,
            }
        },
        methods: {
            submit() {
                this.isLoading = true
                this.$store.dispatch('discount/addDiscount', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Discount Created!')
                    this.$router.push({name: 'discount.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('discount/updateDiscount', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Discount Updated!')
                    this.$router.push({name: 'discount.index'})
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
                user: 'auth/getUser',
                getById: 'discount/getById'
            })
        },
    }
</script>

<style scoped>

</style>
