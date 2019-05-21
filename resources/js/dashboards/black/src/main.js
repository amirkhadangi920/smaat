import Vue from 'vue'

import 'loadMudules'

import Echo from "laravel-echo"
window.io = require('socket.io-client');
window.Echo = new Echo({
  broadcaster: 'socket.io',
  host: window.location.hostname + ':6001',
  auth: {
    headers: {
      Authorization: "Bearer " + localStorage.getItem('JWT')
    }
  }
})

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
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('JWT')}`;
window.axios = axios;

import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

import VueSweetalert2 from 'vue-sweetalert2';

import store from './stores/main'

Vue.use(BlackDashboard);
Vue.use(VueRouter);
Vue.use(RouterPrefetch);
Vue.use(VueAxios, axios);
Vue.use(VueSweetalert2);

/* eslint-disable no-new */
new Vue({
  router,
  i18n,
  store,
  render: h => h(App)
}).$mount("#app");
