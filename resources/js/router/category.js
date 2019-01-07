import Category from '../components/category/Category.vue'
import CategoryForm from '../components/category/CategoryForm'

const category = [
    {
        path: '/category',
        name: 'category.index',
        component: Category,
        meta: {
            auth:true,
            menuIndex: "2"
        }
    },
    {
        path: '/category/:id',
        name: 'category.edit',
        component: CategoryForm,
        meta: {
            auth: true,
            menuIndex: "2"
        }
    },
    {
        path: '/category/new',
        name: 'category.new',
        component: CategoryForm,
        meta: {
            auth: true,
            menuIndex: "2"
        }
    }
]
export default category
