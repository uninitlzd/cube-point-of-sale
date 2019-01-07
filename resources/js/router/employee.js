import Employee from '../components/Employee/Employee.vue'
import EmployeeForm from '../components/Employee/EmployeeForm'

const employee = [
    {
        path: '/employee',
        name: 'employee.index',
        component: Employee,
        meta: {
            auth:true,
            menuIndex: "7"
        }
    },
    {
        path: '/employee/:id',
        name: 'employee.edit',
        component: EmployeeForm,
        meta: {
            auth: true,
            menuIndex: "7"
        }
    },
    {
        path: '/employee/new',
        name: 'employee.create',
        component: EmployeeForm,
        meta: {
            auth: true,
            menuIndex: "7"
        }
    }
]
export default employee
