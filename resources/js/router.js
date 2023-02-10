import Vue from 'vue';
import VueRouter from 'vue-router';

/**
 * Top level route components.
 */
const SecurityToken = () => import('./components/SecurityToken')
const Url = () => import('./components/Url')
const AddUrl = () => import('./components/AddUrl')

/**
 * Register router with vue.
 */
Vue.use(VueRouter);

/**
 * Create vue router and register top level routes.
 */
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'securityToken',
            component: SecurityToken
        },
        {
            path: '/url',
            name: 'url',
            component: Url
        },
        {
            path: '/url/add',
            name: 'addUrl',
            component: AddUrl
        }
    ]
});

export default router;

