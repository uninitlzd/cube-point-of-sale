import Setting from "../components/user/Setting";

const setting = [
    {
        path: '/setting',
        name: 'setting.index',
        component: Setting,
        meta: {
            auth:true,
            menuIndex: "5"
        }
    }
]
export default setting
