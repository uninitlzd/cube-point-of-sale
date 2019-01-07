import localforage from 'localforage';

const store = localforage.createInstance({
    name: 'app',
});

import {mapState} from 'vuex'

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
        }
    }
};

export const setState = (state) => {
    const cachedState = mapStateForCache(state);
    return store.setItem('state', cachedState);
};

export const getState = () => store.getItem('state');

export const deleteState = () => store.removeItem('state');
