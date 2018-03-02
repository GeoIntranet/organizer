/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.$ = window.jQuery = require('jquery');
window.Tether = require('tether');

window.moment = require('moment');
require('./library/moment_local.js');

window.axios = require('axios');

require('bootstrap');

window.Laravel = {
    csrfToken: $('meta[name=csrf-token]').attr("content")
};

window.Vue = require('vue');
window._ = require('lodash');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/ExampleComponent.vue'));
Vue.component('calendar', require('./components/Calendar.vue'));
Vue.component('week', require('./components/Week.vue'));
Vue.component('work', require('./components/Work.vue'));
Vue.component('navbar', require('./components/Navbar.vue'));

window.Event = new Vue();

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

const app = new Vue({
    el: '#app',
});
