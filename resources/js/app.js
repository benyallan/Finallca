 import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
 import money from 'v-money'
 import VueRouter from 'vue-router'
 import VueMask from 'v-mask'
 import moment from 'moment'
 import VeeValidate, { Validator, } from 'vee-validate'
 import Dictionary from './dictionary'
 

// importações das rotas
import ContasCorrente from './components/contas_corrente/ContasCorrente'
import Carteiras from './components/carteiras/CarteirasComponent'
import CartoesCredito from './components/cartoes_credito/CartoesCredito'
import LancamentosComponent from './components/lancamentos/LancamentosComponent'


require('./bootstrap');

window.Vue = require('vue').default;
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(money, {precision: 4})
Vue.use(VueRouter)
Vue.use(VueMask);

const config = {
    errorBagName: 'errors', // Altera a propriedade se houver conflitos.
    fieldsBagName: 'inputs ', // O padrão é fields
    delay: 0,
    locale: 'pt_BR',
    dictionary: Dictionary,
    strict: true,
    enableAutoClasses: false,
    classNames: {
    touched: 'touched',
    untouched: 'untouched',
    valid: 'valid',
    invalid: 'invalid',
    pristine: 'pristine',
    dirty: 'dirty'
    },
    events: 'input|blur',
    inject: true
};
    
// Vue.use(VeeValidate, config);
Vue.use(VeeValidate, config)
Vue.config.debug = true


Vue.filter('momentDate', function (date) {
    return date ? moment(date).format('DD/MM/YYYY') : null
});

Vue.filter('formatPrice', function (value) {
    let val = (value/1).toFixed(2).replace('.', ',')
    return 'R$'+' ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
})

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home/contascorrente',
            name: 'contascorrente',
            component: ContasCorrente
        },
        {
            path: '/home/carteiras',
            name: 'carteiras',
            component: Carteiras
        },
        {
            path: '/home/cartoescredito',
            name: 'cartoescredito',
            component: CartoesCredito
        },
        {
            path: '/home/lancamentos',
            name: 'lancamentos',
            component: LancamentosComponent
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: {
        PainelComponent: () => import('./Components/PainelComponent.vue' /* webpackChunkName: "painel-component" */ ),
    },
    router
});
