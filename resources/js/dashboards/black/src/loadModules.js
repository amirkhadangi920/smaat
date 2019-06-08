import Vue from 'vue';

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
Vue.use(VueMaterial)

import vueNiceScrollbar from 'vue-nice-scrollbar'
Vue.use(vueNiceScrollbar)

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );