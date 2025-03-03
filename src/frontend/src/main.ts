import { createApp } from 'vue'
import 'vue3-toastify/dist/index.css';
import './style.css'
import App from './App.vue'
import {createPinia} from "pinia";
import router from "./router";

const pinia = createPinia()

const app = createApp(App)
    .use(router)
    .use(pinia)

app.mount('#app')