import Discount from '../components/Discount/Discount.vue'
import DiscountForm from '../components/Discount/DiscountForm'
import DiscountProductForm from "../components/discount/DiscountProductForm";

const discount = [
    {
        path: '/discount',
        name: 'discount.index',
        component: Discount,
        meta: {
            auth:true,
            menuIndex: "9"
        }
    },
    {
        path: '/discount/:id',
        name: 'discount.edit',
        component: DiscountForm,
        meta: {
            auth: true,
            menuIndex: "9"
        }
    },
    {
        path: '/discount/:id/products',
        name: 'discount.edit',
        component: DiscountProductForm,
        meta: {
            auth: true,
            menuIndex: "9"
        }
    },
    {
        path: '/discount/new',
        name: 'discount.create',
        component: DiscountForm,
        meta: {
            auth: true,
            menuIndex: "9"
        }
    }
]
export default discount
