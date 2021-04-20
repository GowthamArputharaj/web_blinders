require('./bootstrap');


import Vue from "vue";

import Form from "./Form.vue";

const app = new Vue({
	el: '#app',
    render: h => h(Form),
});

