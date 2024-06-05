require('./bootstrap');

require('animsition')
require('animate')

import AlumniFormResult from './components/AlumniFormResult.vue'

import Vue from 'vue'

new Vue({
    el: '#app',
    components: {
        AlumniFormResult,
    },
    mounted() {
    },
    methods: {
    }
})