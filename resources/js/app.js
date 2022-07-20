 import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
 import money from 'v-money'
 import VueRouter from 'vue-router'

// importações das rotas
import ContasCorrente from './components/contas_corrente/ContasCorrente'
import Carteiras from './components/carteiras/CarteirasComponent'

require('./bootstrap');

window.Vue = require('vue').default;
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(money, {precision: 4})
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/contascorrente',
            name: 'contascorrente',
            component: ContasCorrente
        },
        {
            path: '/carteiras',
            name: 'carteiras',
            component: Carteiras
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: {
        CarteirasComponent: () => import('./components/carteiras/CarteirasComponent.vue' /* webpackChunkName: "carteiras-component" */ ),
        ContasCorrente: () => import('./components/contas_corrente/ContasCorrente.vue' /* webpackChunkName: "contas-corrente" */ ),
        PainelComponent: () => import('./Components/PainelComponent.vue' /* webpackChunkName: "painel-component" */ ),
    },
    router
});
