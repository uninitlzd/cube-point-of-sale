import Material from '../components/material/Material.vue'
import MaterialForm from '../components/material/MaterialForm.vue'

const material = [
    {
        path: '/material',
        name: 'material.index',
        component: Material,
        meta: {
            auth:true,
            menuIndex: "5"
        }
    },{
        path: '/material/:id',
        name: 'material.edit',
        component: MaterialForm,
        meta: {
            auth: true,
            menuIndex: "5"
        }
    },
    {
        path: '/material/new',
        name: 'material.new',
        component: MaterialForm,
        meta: {
            auth: true,
            menuIndex: "5"
        }
    }
]
export default material
