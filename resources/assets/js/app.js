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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/ExampleComponent.vue'));
Vue.component('calendar', require('./components/Calendar.vue'));
Vue.component('week', require('./components/Week.vue'));
Vue.component('hello', require('./components/Hello.vue'));
Vue.component('drag', require('./components/Drag.vue'));




window.Event = new Vue();

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
import Vue from 'vue'
import { Vue2Dragula } from 'vue2-dragula'

Vue.use(Vue2Dragula, {
    logging: {
        service: false // to only log methods in service (DragulaService)
    }
});
const app = new Vue({
    el: '#app',
});
