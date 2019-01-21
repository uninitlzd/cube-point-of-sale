import Order from '../components/order/Order.vue'
import OrderDetail from "../components/order/OrderDetail";

const category = [
    {
        path: '/order',
        name: 'order.index',
        component: Order,
        meta: {
            auth:true,
            menuIndex: "4"
        }
    },
    {
        path: '/order/:id',
        name: 'order.show',
        component: OrderDetail,
        meta: {
            auth:true,
            menuIndex: "4"
        }
    }
]
export default category
