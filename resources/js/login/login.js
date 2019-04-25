import Vue from 'vue'
import Login from './Login.vue'

import axios from 'axios'
window.axios = axios

new Vue({
    render: h => h(Login)
}).$mount("#app");