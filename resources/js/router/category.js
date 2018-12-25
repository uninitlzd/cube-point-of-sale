import Category from '../components/category/Category.vue'
import CategoryForm from '../components/category/CategoryForm'

const category = [
    {
        path: '/category',
        name: 'Category Index',
        component: Category,
        meta: {
            auth:true,
            menuIndex: "2"
        }
    },
    {
        path: '/category/:id',
        name: 'Category Form',
        component: CategoryForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    },
    {
        path: '/category/new',
        name: 'Category New Form',
        component: CategoryForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    }
]
export default category
