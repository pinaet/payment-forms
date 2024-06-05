require('./bootstrap')

import ApplicationFee from './components/ApplicationFee.vue'

// import Vue from 'vue'
import VueSelect from 'vue-select'

Vue.component('vue-select', VueSelect)

new Vue({
    el: '#app',
    components: {
        ApplicationFee,
    },
    mounted() {
    },
    methods: {
    }
})
