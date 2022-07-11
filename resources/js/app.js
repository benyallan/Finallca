/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import BootstrapVue from 'bootstrap-vue';
 import money from 'v-money'

require('./bootstrap');

window.Vue = require('vue').default;
Vue.use(BootstrapVue);
Vue.use(money, {precision: 4})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('carteiras-component', require('./components/carteiras/CarteirasComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        CarteirasComponent: () => import('./components/carteiras/CarteirasComponent.vue' /* webpackChunkName: "carteiras-component" */ ),
        ContasCorrente: () => import('./components/contas_corrente/ContasCorrente.vue' /* webpackChunkName: "contas-corrente" */ ),
    }
});
