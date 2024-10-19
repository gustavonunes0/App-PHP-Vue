import { createRouter, createWebHistory } from 'vue-router';
import UserLogin from '../components/UserLogin.vue';
import UserRegister from '../components/UserRegister.vue';
import UserDashboard from '../components/UserDashboard.vue';

const routes = [
    { path: '/', component: UserDashboard },
    { path: '/login', component: UserLogin },
    { path: '/register', component: UserRegister },
    { path: '/dashboard', component: UserDashboard, meta: { requiresAuth: true } }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token') !== null; 
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ path: '/login' });
    } else {
        next();
    }
});

export default router;
