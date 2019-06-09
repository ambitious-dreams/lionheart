import './bootstrap';
import Vue from 'vue';
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: '#3490dc',
  failedColor: '#de1371',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
});

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import App from './components/App.vue';

const app = new Vue({
    el: '#app',
    template: '<App/>',
    components: {
        App
    },
});