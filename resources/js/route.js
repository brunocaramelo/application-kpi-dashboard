import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/logout',
            component: () => import('./Pages/Login/Logout.vue')
        },
        {
            path: '/login',
            component: () => import('./Pages/Login/Login.vue')
        },
        {
            path: '/kpis',
            component: () => import('./Pages/Kpis/List/List.vue')
        },
        {
            path: '/kpis/novo',
            component: () => import('./Pages/Kpis/New/New.vue')
        },
        {
            path: '/kpis/:kpiId',
            component: () => import('./Pages/Kpis/Edit/Edit.vue')
        },
        {
            path: '/',
            component: () => import('./Pages/Home/Home.vue')
        },
        {
            path: '/home',
            component: () => import('./Pages/Home/Home.vue')
        }
    ],
})

router.beforeEach((to, from, next) => {
    if (to.path !== '/login' && !isAuthenticated()) {
        return next({path: '/login'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_USER_TOKEN'))
}

export default router;
