
window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes';
const router = new VueRouter({
    // mode: 'history',
    routes
});


import app from './app.vue';

const app1 = new Vue({
    router,
    render: h=>h(app)
}).$mount('#app');
