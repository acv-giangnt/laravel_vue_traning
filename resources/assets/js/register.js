window.Vue = require('vue');

window.axios = require('axios');

Vue.component('register', require('./components/register.vue'));
const formlogin = new Vue({
    el: '#register'
});