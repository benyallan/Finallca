<template>
    <div class="container">
        <div class="row justify-content-center">
            <b-button v-b-modal.nova-carteira-modal variant="success">Teste de modal</b-button>
        </div>
        <form action="" method="post">
            <div class="form-group">
              <label for="">Nome</label>
              <input type="text"
                class="form-control" name="nome" id="" aria-describedby="helpId" placeholder="Nome da carteira">
              <small id="helpId" class="form-text text-muted">Nome da nova carteira</small>
            </div>
            <money v-model="price" v-bind="money"></money> {{price}}
        </form>

  <b-modal id="modal-1" title="BootstrapVue">
    <p class="my-4">Hello from modal!</p>
  </b-modal>
    <nova-carteira-modal></nova-carteira-modal>
    </div>
</template>

<script>
    import {Money} from 'v-money'
    
    export default {
        components: {
            Money,
            NovaCarteiraModal: () => import('./modals/NovaCarteiraModal.vue' /* webpackChunkName: "nova-carteira-modal" */),
        },
        methods: {
            showModal() {
                this.$bvModal.show('nova-carteira-modal')
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        data () {
            return {
                price: 123.45,
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: ' ',
                    precision: 2,
                    masked: false
                }
            }
        }
    }
</script>
