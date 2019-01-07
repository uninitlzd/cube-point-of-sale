import { setState } from './storage';

const shouldSkipCache = (mutation) => {
    return false
};

const plugin = (store) => {
    store.subscribe((mutation, state) => {
            console.log('state', state)
            console.log('mutation', mutation)
            setState(state).catch(err => console.warn('failed to cache state', err));
    });
};

export default plugin;
