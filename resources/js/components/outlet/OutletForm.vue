<template>
    <dashboard-shell>
        <el-col :span="24" class="pr-0">
            <el-scrollbar class="h-100 scrollbar-component">
                <el-row class="ml-5 mt-4 mr-4">
                    <el-col :span="23" class="py-4">
                        <h2 class="mb-3" v-if="editMode">{{ form.name }}</h2>
                        <h2 class="mb-3" v-else>Outlet</h2>
                        <el-breadcrumb separator="/" class="mb-5">
                            <el-breadcrumb-item to="/outlet">Outlet Management</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-if=editMode>Outlet Form - Edit</el-breadcrumb-item>
                            <el-breadcrumb-item to=link v-else>Outlet Form</el-breadcrumb-item>
                        </el-breadcrumb>
                        <el-card class="box-card pt-4 mr-1">
                            <el-form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                     label-position="top" ref="form" :model=form :rules=rules>
                                <el-form-item label="Name" prop="name">
                                    <el-input size="medium"
                                              placeholder="Outlet Name eg: Kedai Cabang Keputih"
                                              v-model="form.name"></el-input>
                                </el-form-item>
                                <el-row type="flex" :gutter="10">
                                    <el-col :span="12">
                                        <el-form-item label="Address" prop="address">
                                            <el-input type="textarea" size="medium" placeholder="Address"
                                                      v-model="form.address"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="Phone Number" prop="phone">
                                            <el-input type="text" size="medium" placeholder="Phone Number"
                                                      v-model="form.phone"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-form-item size="medium" class="mb-0">
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
    import {mapState, mapGetters} from 'vuex'
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
        name: "OutletForm",
        components: {DashboardShell},
        created() {
            if (this.$route.params.id !== 'new') {
                this.editMode = true
                let outlet = this.getById(parseInt(this.$route.params.id))[0]
                this.form = new Form({
                    name: outlet.name,
                    address: outlet.address,
                    phone: outlet.phone
                })
            }
        },
        data() {
            return {
                editMode: false,
                form: new Form({
                    name: '',
                    address: '',
                    phone: ''
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
                this.$store.dispatch('outlet/addOutlet', this.form).then(response => {
                    this.isLoading = false
                    this.$message.success('Outlet Created!')
                }).catch(error => {
                    this.isLoading = false
                    this.$message.error('Save Failed!')
                })
            },

            update() {
                this.isLoading = true
                this.$store.dispatch('outlet/updateOutlet', {
                    index: this.$route.params.id,
                    form: this.form
                }).then(response => {
                    this.isLoading = false
                    this.$message.success('Outlet Updated!')
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
                getById: 'outlet/getById'
            })
        },
    }
</script>

<style scoped>

</style>
