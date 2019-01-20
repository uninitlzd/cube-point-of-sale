import localforage from 'localforage';

const store = localforage.createInstance({
    name: 'app',
});

const mapStateForCache = (state) => {
    return {
        auth: {
            logged: state.auth.logged,
            user: state.auth.user
        },
        shop: {
            shop: state.shop.shop
        },
        outlet: {
            outlets: state.outlet.outlets
        },
        category: {
            categories: state.category.categories
        },
        product: {
            products: state.product.products
        },
        material: {
            materials: state.material.materials
        },
        employee: {
            employees: state.employee.employees
        },
        member: {
            members: state.member.members
        },
        discount: {
            discounts: state.discount.discounts
        },
        customerType: {
            customerTypes: state.customerType.customerTypes
        },
        menu: {
            cashierView: state.menu.cashierView
        }
    }
};

export const setState = (state) => {
    const cachedState = mapStateForCache(state);
    return store.setItem('state', cachedState);
};

export const getState = () => store.getItem('state');

export const deleteState = () => store.removeItem('state');
