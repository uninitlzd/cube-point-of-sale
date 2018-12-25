import Product from '../components/Product/Product.vue'
import ProductForm from '../components/Product/ProductForm'

const product = [
    {
        path: '/product',
        name: 'Product Index',
        component: Product,
        meta: {
            auth:true,
            menuIndex: "3"
        }
    },
    {
        path: '/product/:id',
        name: 'Product Form',
        component: ProductForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    },
    {
        path: '/product/new',
        name: 'Product New Form',
        component: ProductForm,
        meta: {
            auth: true,
            menuIndex: "1"
        }
    }
]
export default product
