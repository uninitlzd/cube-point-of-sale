import Member from '../components/Member/Member.vue'
import MemberForm from '../components/Member/MemberForm'

const member = [
    {
        path: '/member',
        name: 'Member Index',
        component: Member,
        meta: {
            auth:true,
            menuIndex: "8"
        }
    },
    {
        path: '/member/:id',
        name: 'Member Form',
        component: MemberForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    },
    {
        path: '/member/new',
        name: 'Member New Form',
        component: MemberForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    }
]
export default member
