require('./bootstrap')

import SchoolFee from './components/SchoolFee.vue'

import Vue from 'vue'

window.Vue = require("vue")

new Vue({
    el: '#app',
    components: {
        SchoolFee,
    },
    mounted() {
    },
    methods: {
    }
})
