import Vue from "vue";

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import VueRouter from "vue-router";
import RouterPrefetch from 'vue-router-prefetch'
import App from "./App";
// TIP: change to import router from "./router/starterRouter"; to start with a clean layout
import router from "./router/index";

import BlackDashboard from "./plugins/blackDashboard";
import i18n from "./i18n"
import './registerServiceWorker'

import axios from 'axios'
import VueAxios from 'vue-axios'

import VueSweetalert2 from 'vue-sweetalert2';
import VModal from 'vue-js-modal'

window.axios = axios;


Vue.use(BlackDashboard);
Vue.use(VueRouter);
Vue.use(RouterPrefetch);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);
Vue.use(VueSweetalert2);
Vue.use(VModal)

/* eslint-disable no-new */
new Vue({
  router,
  i18n,
  render: h => h(App)
}).$mount("#app");
