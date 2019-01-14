import Member from '../components/Member/Member.vue'
import MemberForm from '../components/Member/MemberForm'

const customerType = [
    {
        path: '/customer-type',
        name: 'customer-type.index',
        component: CustomerType,
        meta: {
            auth:true,
            menuIndex: "8"
        }
    },
    {
        path: '/customer-type/:id',
        name: 'customer-type.edit',
        component: CustomerTypeForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    },
    {
        path: '/customer-type/new',
        name: 'customer-type.create',
        component: MemberForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    }
]
export default customerType
