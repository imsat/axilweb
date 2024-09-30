import { createApp } from 'vue'
import './style.css'
import '@mdi/font/css/materialdesignicons.css'
import App from './App.vue'
import router from "./router.js";
import { piniaPluginRouter } from './plugins/piniaPluginRouter';
import { install } from "vue3-recaptcha-v2";



const app = createApp(App)

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {createPinia} from "pinia";

const vuetify = createVuetify({
    components,
    directives,
})
const pinia = createPinia()
pinia.use(piniaPluginRouter)

app.use(install, {
    sitekey: import.meta.env.VITE_API_RECAPTCHA_SITE_KEY,
    cnDomains: false,
})
app.use(pinia)
app.use(router)
app.use(vuetify)
app.mount('#app')
