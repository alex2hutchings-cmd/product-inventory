import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/Home.vue'
import ProductPage from '../pages/ProductPage.vue'

const routes = [
    {
        path: '/',
        component: Home,
    },
    {
        path: '/products/:id',
        component: ProductPage,
        props: true,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router