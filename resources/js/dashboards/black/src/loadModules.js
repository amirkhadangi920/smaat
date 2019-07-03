import Vue from 'vue';

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/fa'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { locale });

import "vue-material-design-icons/styles.css"
import MenuIcon from "vue-material-design-icons/Menu.vue"
Vue.component("menu-icon", MenuIcon)

import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
Vue.use(VueMaterial)

import vueNiceScrollbar from 'vue-nice-scrollbar'
Vue.use(vueNiceScrollbar)

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );