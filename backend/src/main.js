// import './assets/main.css'
import './assets/index.css'
import currencyEUR from './components/filters/currency'
import store from './store'
import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(store)
app.mount('#app')
app.config.globalProperties.$filters = {
    currencyEUR
}
