import './bootstrap';


import {createApp} from 'vue'

import App from './App.vue'
import router from './route'

import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config'
// import 'primevue/resources/primevue.min.css'
// import 'primeicons/primeicons.css'
import ToastService from 'primevue/toastservice';

const pinia = createPinia();

const app = createApp(App)

app.use(router)
   .use(pinia)
   .use(PrimeVue)
   .use(ToastService)


app.component('EasyDataTable', Vue3EasyDataTable);

app.mount("#app")
