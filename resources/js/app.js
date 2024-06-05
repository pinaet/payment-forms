require('./bootstrap');

require('animsition')
require('animate')
require('select2')
require('daterangepicker')
// require('countdowntime')

import AlumniForm from './components/AlumniForm.vue'

import Vue from 'vue'

new Vue({
    el: '#app',
    components: {
        AlumniForm,
    },
    mounted() {
    },
    methods: {
    }
})
