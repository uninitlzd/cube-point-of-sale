import Order from '../components/order/Order.vue'

const category = [
    {
        path: '/order',
        name: 'Order Index',
        component: Order,
        meta: {
            auth:true,
            menuIndex: "4"
        }
    },
]
export default category
