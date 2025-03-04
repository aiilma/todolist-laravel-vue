import {defineStore} from 'pinia';
import {useAxiosStore} from './useAxiosStore';
import {onMounted, ref} from 'vue';
import {toast} from "vue3-toastify";
import {useRouter} from "vue-router";
import type {Nullable} from "../types/basic.ts";

export const useAuthStore = defineStore('AuthStore', () => {
    const router = useRouter();
    const {http} = useAxiosStore();

    const user = ref(null);
    const token = ref<Nullable<string>>(localStorage.getItem('token'));

    const setToken = (newToken: string) => {
        token.value = newToken;
        localStorage.setItem('token', newToken);
    };

    const removeToken = () => {
        token.value = null;
        localStorage.removeItem('token');
    };

    const register = async (credentials: any) => { // todo types for user creds
        try {
            await http.post('/auth/register', credentials);

            toast.success('Registration successful! Now use your data to login');
            router.push({name: 'LoginPage'});
        } catch (error) {
            console.error('Registration failed:', error);
            toast.error('Registration failed!');
            throw error;
        }
    };

    const login = async (credentials: any) => { // todo types for user creds
        try {
            const response = await http.post('/auth/login', credentials);

            setToken(response.data.access_token);
            await fetchUser();

            toast.success('Login successful!');
            router.push({name: 'TasksPage'});
        } catch (error) {
            console.error('Login failed:', error);
            toast.error('Login failed!');
            throw error;
        }
    };

    const logout = async () => {
        try {
            await http.post('/auth/logout');

            removeToken();
            user.value = null;

            router.push({name: 'LoginPage'});
        } catch (error) {
            console.error('Logout failed:', error);
            toast.error('Logout failed!');
            throw error;
        }
    };

    const fetchUser = async () => {
        try {
            const response = await http.post('/auth/user');

            user.value = response.data;
        } catch (error) {
            console.error('Fetch user failed:', error);
            throw error;
        }
    };

    const syncAuthUser = async () => {
        if (token.value) {
            try {
                await fetchUser();
            } catch (error) {
                await logout();
            }
        }
    };

    onMounted(() => {
        syncAuthUser();
    });

    return {
        user,
        register,
        login,
        logout,
        fetchUser,
        syncAuthUser,
        setToken,
        removeToken,
        token
    };
});