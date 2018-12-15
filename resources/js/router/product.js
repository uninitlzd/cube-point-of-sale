import Product from '../components/Product/Product.vue'

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
]
export default product
