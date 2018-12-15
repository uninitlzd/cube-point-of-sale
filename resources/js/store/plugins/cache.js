import { setState } from './storage';

const shouldSkipCache = (mutation) => {
    return false
};

const plugin = (store) => {
    store.subscribe((mutation, state) => {
            setState(state).catch(err => console.warn('failed to cache state', err));
    });
};

export default plugin;
