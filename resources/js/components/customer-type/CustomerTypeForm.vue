<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Jenis Pelanggan</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/customer-type">Jenis Pelanggan</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Jenis Pelanggan - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Jenis Pelanggan</el-breadcrumb-item>
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
                                        <el-form-item label="Discount Percentage" prop="discount_percentage">
                                            <el-input size="medium"
                                                      placeholder="Contoh: 4, 12, atau 20"
                                                      v-model="form.discount_percentage"></el-input>
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
        name: "CustomerTypeForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true

                let customerType = this.getById(parseInt(this.$route.params.id))

                this.form = new Form({
                    name: customerType.name,
                    discount_percentage: customerType.discount_percentage,
                })
            }

            this.form.shop_id = this.user.shop.id
        },
        data() {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    discount_percentage: '',
                    shop_id: ''
                }),
                rules: {
                    name: [
                        {required: true, message: 'Please input name', trigger: 'blur'},
                    ],
                    discount_percentage: [
                        {required: true, message: 'Please input Discount Percentage', trigger: 'blur'},
                    ],
                },
                isLoading: false,
            }
        },
        methods: {
            submit() {
                this.isLoading = true
                this.$store.dispatch('customerType/addCustomerType', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Customer Type Created!')
                    this.$router.push({name: 'customer-type.index'})
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('customerType/updateCustomerType', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Customer Type Updated!')
                    this.$router.push({name: 'customer-type.index'})
                }).catch(error => {
                    console.log(error)
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
                getById: 'customerType/getById'
            })
        },
    }
</script>

<style scoped>

</style>
