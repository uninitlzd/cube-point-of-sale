import axios from 'axios'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import Navbar from './components/Navbar.vue'
import Vue from 'vue'
import Vuebar from 'vuebar'
import VueRouter from 'vue-router'
import VueOffline from 'vue-offline'
import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'
import Bars from 'vuebars'


Vue.use(ElementUI)
Vue.use(DataTables)
Vue.use(DataTablesServer)
Vue.use(Vuebar)
Vue.use(VueRouter)
Vue.use(VueOffline)
Vue.use(VueChartkick, {adapter: Chart})
Vue.use(Bars)

Vue.component('Navbar', Navbar)

locale.use(lang)
window.axios = axios

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.token


