import {createRouter, createWebHistory} from "vue-router";
import TasksPage from "../views/TasksPage.vue";
import RegisterPage from "../views/RegisterPage.vue";
import LoginPage from "../views/LoginPage.vue";

const routes = [
    {
        path: '/',
        name: 'TasksPage',
        component: TasksPage
    },
    {
        path: '/register',
        name: 'RegisterPage',
        component: RegisterPage
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: LoginPage
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router