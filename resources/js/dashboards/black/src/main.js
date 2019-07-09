import Vue from 'vue'

import './loadModules'
// import './laravel_echo'
import './axios'

import VueRouter from "vue-router";
import VueMeta from 'vue-meta'

import RouterPrefetch from 'vue-router-prefetch'
import App from "./App";
import router from "./router/index";

import BlackDashboard from "./plugins/blackDashboard";
import i18n from "./i18n"
import './registerServiceWorker'

import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

import VueSweetalert2 from 'vue-sweetalert2';

import store from './stores/main'

Vue.use(BlackDashboard);
Vue.use(VueMeta)
Vue.use(VueRouter);
Vue.use(RouterPrefetch);
Vue.use(VueSweetalert2);

/* eslint-disable no-new */
new Vue({
  router,
  i18n,
  store,
  render: h => h(App)
}).$mount("#app");
