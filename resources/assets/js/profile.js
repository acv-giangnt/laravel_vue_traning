window.Vue = require('vue');

window.axios = require('axios');

Vue.component('setting', require('./components/profile.vue'));
const formlogin = new Vue({
    el: '#settings'
});