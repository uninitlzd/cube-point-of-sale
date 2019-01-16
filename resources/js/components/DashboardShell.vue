<template>
    <div class="d-flex flex-column h-100">
        <el-row id="main-top-nav" type="flex">
            <el-col :span=12>
                <ul class="list-inline d-flex flex-row h-100">
                    <li class="list-inline-item my-auto bg-primary h-100 text-white d-flex justify-content-center">
                        <router-link to="/dashboard" class=" align-self-center text-center text-white">
                            <i class="material-icons" style="width: 64px">
                                dashboard
                            </i>
                        </router-link>
                    <li class="list-inline-item my-auto px-4 d-flex">
                        <div class="align-self-center d-flex flex-row">
                            <i class="material-icons text-center mr-3" @click="isCollapsed = !isCollapsed">
                                menu
                            </i>
                            <p class="mb-0"><span class="font-weight-black">GenBI</span> PoS</p>
                        </div>
                    </li>
                </ul>
            </el-col>
            <el-col :span=12>
                <ul class="list-inline d-flex h-100 justify-content-end">
                    <li class="list-inline-item my-auto">
                        <router-link to="/cashier">
                            <el-button size="small" type="primary" plain round >
                                <i class="material-icons mr-2 align-middle" style="font-size: 11pt; margin-bottom: 1px">store</i>Tampilan Kasir
                            </el-button>
                        </router-link>
                    </li>
                    <li class="list-inline-item">
                        <el-dropdown class="h-100 d-flex align-self-center">
                            <ul class="list-inline d-flex flex-row ml-auto h-100 justify-content-end el-dropdown-link pr-3">
                                <li class="list-inline-item my-auto rounded-circle overflow-hidden mr-3" style="width: 30px;">
                                    <img
                                        src="/images/avatar.jpg" alt="" class="w-100 image-fit-cover"></li>
                                <li class="list-inline-item my-auto">Alfredo Eka</li>
                                <li class="list-inline-item my-auto"><i class="el-icon-arrow-down el-icon--right"></i></li>
                            </ul>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item>Pengaturan</el-dropdown-item>
                                <line></line>
                                <el-dropdown-item divided @click.native="logout">Keluar</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </li>
                </ul>
            </el-col>
        </el-row>
        <el-row type="flex" class="flex-fill mx-0 ">
            <el-scrollbar class="h-100 scrollbar-component" :class="[isCollapsed ? collapsedClass : openedClass]"
                          style="min-width: 64px">
                <nav id="main-side-nav">
                    <el-menu :default-active="activeIndex" class="el-menu-vertical-demo h-100 " :collapse="isCollapsed"
                             active-text-color="#007bff"
                             :router=true>
                        <template v-if="shop != null">
                            <el-menu-item index="1" route="/outlet" data-toggle="tooltip" title="Outlet">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    store
                                </i>
                                <span class="align-self-center">Outlets</span>
                            </el-menu-item>
                            <el-menu-item index="2" route="/category" data-toggle="tooltip" title="Kategori">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    category
                                </i>
                                <span class="align-self-center">Categories</span>
                            </el-menu-item>
                            <el-menu-item index="3" route="/product" data-toggle="tooltip" title="Produk">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    view_module
                                </i>
                                <span class="align-self-center">Products</span>
                            </el-menu-item>
                            <el-menu-item index="4" route="/order">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    receipt
                                </i>
                                <span class="align-self-center">Orders History</span>
                            </el-menu-item>
                            <el-menu-item index="5" route="/material">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    group_work
                                </i>
                                <span class="align-self-center">Ingredient</span>
                            </el-menu-item>
                            <el-menu-item index="6" route="/report">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    bar_chart
                                </i>
                                <span class="align-self-center">Insight</span>
                            </el-menu-item>
                            <el-menu-item index="7" route="/employee">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    supervisor_account
                                </i>
                                <span class="align-self-center">Employee</span>
                            </el-menu-item>
                            <el-menu-item index="8" route="/member">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    card_membership
                                </i>
                                <span class="align-self-center">Membership</span>
                            </el-menu-item>
                            <el-menu-item index="9" route="/discount">
                                <i class="material-icons mr-2 align-self-center" style="padding-left: 20px">
                                    local_offer
                                </i>
                                <span class="align-self-center">Discount</span>
                            </el-menu-item>
                        </template>
                    </el-menu>
                </nav>
            </el-scrollbar>
            <slot></slot>
        </el-row>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex'

    export default {
        name: "DashboardShell",
        data() {
            return {
                isCollapsed: true,
                collapsedClass: 'collapsed',
                openedClass: 'opened'
            }
        },
        computed: {
            ...mapState({ activeIndex: state => state.menu.activeIndex }),
            ...mapState({ shop: state => state.shop.shop })
        },
        methods: {
            logout() {
                this.$store.dispatch('auth/logout')
            }
        }
    }
</script>

<style type="scss" scoped>
    .collapsed {
        width: 67px;
        transition: width 200ms ease-out;

    }

    .opened {
        width: 240px;
        transition: width 50ms ease-in;
    }
</style>
