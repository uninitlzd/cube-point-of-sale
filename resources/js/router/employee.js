import Employee from '../components/Employee/Employee.vue'
import EmployeeForm from '../components/Employee/EmployeeForm'

const employee = [
    {
        path: '/employee',
        name: 'Employee Index',
        component: Employee,
        meta: {
            auth:true,
            menuIndex: "7"
        }
    },
    {
        path: '/employee/:id',
        name: 'Employee Form',
        component: EmployeeForm,
        meta: {
            auth: true,
            menuIndex: "7"
        }
    },
    {
        path: '/employee/new',
        name: 'Employee New Form',
        component: EmployeeForm,
        meta: {
            auth: true,
            menuIndex: "7"
        }
    }
]
export default employee
