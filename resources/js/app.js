/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Bootstrap
import 'bootstrap';

// Fontawesome
import '@fortawesome/fontawesome-free/js/all';

// Axios
window.axios = require('axios');

// Vue
window.Vue = require('vue');

// info user autenticato
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

import Main from './Main';
import router from './router';

const app = new Vue({
    el: '#root',
    render: h => h(Main),
    router
});