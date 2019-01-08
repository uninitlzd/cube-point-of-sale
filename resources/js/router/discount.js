import Member from '../components/Member/Member.vue'
import MemberForm from '../components/Member/MemberForm'

const member = [
    {
        path: '/member',
        name: 'member.index',
        component: Member,
        meta: {
            auth:true,
            menuIndex: "8"
        }
    },
    {
        path: '/member/:id',
        name: 'member.edit',
        component: MemberForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    },
    {
        path: '/member/new',
        name: 'member.create',
        component: MemberForm,
        meta: {
            auth: true,
            menuIndex: "8"
        }
    }
]
export default member
