import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './stores'
import './plugins/axios.js'
import vuetify from './plugins/vuetify'
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
import 'tiptap-vuetify/dist/main.css'
// import CKEditor from '@ckeditor/ckeditor5-vue';
// ck editor


// Vue.use( CKEditor );

new Vue({
  router,
  vuetify,
   store,
  render: h => h(App)
}).$mount('#app')
Vue.use(TiptapVuetifyPlugin, {
  // the next line is important! You need to provide the Vuetify Object to this place.
  vuetify, // same as "vuetify: vuetify"
  // optional, default to 'md' (default vuetify icons before v2.0.0)
  iconsGroup: 'md'
})