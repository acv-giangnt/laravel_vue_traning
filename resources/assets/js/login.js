window.Vue = require('vue');

window.axios = require('axios');

Vue.component('form-login', require('./components/formlogin.vue'));
const formlogin = new Vue({
    el: '#form-login'
});