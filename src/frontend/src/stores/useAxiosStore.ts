import type {AxiosInstance} from 'axios'
import axios from "axios";
import {ref} from "vue";
import {defineStore, storeToRefs} from "pinia";
import {useAuthStore} from "./useAuthStore.ts";

export const useAxiosStore = defineStore('AxiosStore', () => {
    const authStore = useAuthStore();
    const {token} = storeToRefs(authStore)

    const axiosInstance = axios.create({
        baseURL: `http://127.0.0.1:8000/api`, // todo
        headers: {'Content-Type': 'application/json'}
    })

    axiosInstance.interceptors.request.use(config => {
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        return config;
    });

    axiosInstance.interceptors.response.use(
        response => response.data,
        async error => {
            const tokenNotValid = error.response.status === 401 && token.value

            if (tokenNotValid) {
                try {
                    const response = await axiosInstance.post('/auth/refresh');
                    authStore.setToken(response.data.access_token);
                    error.config.headers['Authorization'] = `Bearer ${response.data.access_token}`;

                    return axiosInstance(error.config);
                } catch (refreshError) {
                    await authStore.logout();
                }
            }

            return Promise.reject(error);
        }
    );

    const http = ref<AxiosInstance>(axiosInstance)

    return {http};
})