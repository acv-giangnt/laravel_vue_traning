window.Vue = require('vue');

window.axios = require('axios');

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
Vue.component('danh-sach-nguoi-dung', require('./components/danhsachnguoidung.vue'));
const test = new Vue({
    el: '#danh-sach-nguoi-dung'
});