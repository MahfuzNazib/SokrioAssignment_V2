import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2'

Vue.prototype.$apiAdress = 'http://127.0.0.1:8000'
Vue.prototype.$apiURL = 'http://127.0.0.1:8000/api'

Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.use(VueSweetalert2)

new Vue({
  el: '#app',
  router,
  store,  
  icons,
  template: '<App/>',
  components: {
    App
  },
})
