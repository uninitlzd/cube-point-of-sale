import Product from '../components/Product/Product.vue'
import ProductForm from '../components/Product/ProductForm'
import ProductStock from '../components/product/stock/ProductStock';

const product = [
    {
        path: '/product',
        name: 'product.index',
        component: Product,
        meta: {
            auth:true,
            menuIndex: "3"
        }
    },
    {
        path: '/product/:id',
        name: 'product.form',
        component: ProductForm,
        meta: {
            auth: true,
            menuIndex: "3"
        }
    },
    {
        path: '/product/new',
        name: 'Product New Form',
        component: ProductForm,
        meta: {
            auth: true,
            menuIndex: "3"
        }
    },
    {
        path: '/product/:id/stocks',
        name: 'product.stock',
        component: ProductStock,
        meta: {
            auth: true,
            menuIndex: "3"
        }
    }
]
export default product
