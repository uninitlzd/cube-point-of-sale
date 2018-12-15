import Category from '../components/category/Category.vue'

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
]
export default category
