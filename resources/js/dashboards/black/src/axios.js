import Vue from 'vue'

import axios from 'axios'
import VueAxios from 'vue-axios'
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('JWT')}`;
axios.interceptors.response.use(function (response) {
  
  if (response.data.errors)
  {
    const errors = response.data.errors

    if ( errors[0].message = 'validation' && errors[0].validation )
    {
      return Promise.reject({
        type: 'validation',
        messages: errors[0].validation
      })
    }

    return Promise.reject(errors)
  } 
  else
    return response

}, function (error) {

  console.log('fuck error')
  
  return Promise.reject(error);
});

window.axios = axios;
Vue.use(VueAxios, axios);