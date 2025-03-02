import { createApp } from 'vue'
import 'vue3-toastify/dist/index.css';
import './style.css'
import App from './App.vue'
import router from "./router";

const app = createApp(App)
    .use(router)

app.mount('#app')