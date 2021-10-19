/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Bootstrap
import 'bootstrap';

// TomTom Maps
// import tt from '@tomtom-international/web-sdk-maps';

// Fontawesome
import '@fortawesome/fontawesome-free/js/all';

// style
import '../sass/app.scss'

// Axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'HMLHttpRequest';

// Vue
window.Vue = require('vue');
delete window.axios.defaults.headers.common['X-Requested-With'];

// info user autenticato
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');


import Main from './Main';
import router from './router';
import Axios from 'axios';

const app = new Vue({
    el: '#root',
    render: h => h(Main),
    router
});