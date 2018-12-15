import Outlet from '../components/outlet/Outlet.vue'
import OutletForm from '../components/outlet/OutletForm.vue'

const outlet = [
    {
        path: '/outlet',
        name: 'Outlet Index',
        component: Outlet,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    },
    {
        path: '/outlet/:id',
        name: 'Outlet Form',
        component: OutletForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    },
    {
        path: '/outlet/new',
        name: 'Outlet New Form',
        component: OutletForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    },
]
export default outlet
