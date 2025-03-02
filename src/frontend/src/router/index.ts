import {createRouter, createWebHistory} from "vue-router";
import TasksPage from "../views/TasksPage.vue";
import RegisterPage from "../views/RegisterPage.vue";
import LoginPage from "../views/LoginPage.vue";
import {useAuthStore} from "../stores/useAuthStore.ts";

const routes = [
    {
        path: '/',
        name: 'TasksPage',
        component: TasksPage,
        meta: { requiresAuth: true }
    },
    {
        path: '/register',
        name: 'RegisterPage',
        component: RegisterPage,
        meta: { requiresGuest: true }
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: LoginPage,
        meta: { requiresGuest: true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, _, next) => {
    const authStore = useAuthStore();
    if (to.meta.requiresAuth && !authStore.token) {
        next({ name: 'LoginPage' });
    } else if (to.meta.requiresGuest && authStore.token) {
        next({ name: 'TasksPage' });
    } else {
        next();
    }
});

export default router