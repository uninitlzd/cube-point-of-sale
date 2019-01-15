import Cashier from "../components/cashier/Cashier";

const cashier = [
    {
        path: '/cashier',
        name: 'cashier.index',
        component: Cashier,
        meta: {
            auth:true,
            menuIndex: "2"
        }
    },
]

export default cashier
