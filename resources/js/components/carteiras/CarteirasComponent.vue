<template>
    <div class="container">
        <div class="row justify-content-center">
            <b-button v-b-modal.nova-carteira-modal variant="success">Teste de modal</b-button>
        </div>
        

  <b-modal id="modal-1" title="BootstrapVue">
    <p class="my-4">Hello from modal!</p>
  </b-modal>
    <nova-carteira-modal></nova-carteira-modal>
    </div>
</template>

<script>
    export default {
        components: {
            NovaCarteiraModal: () => import('./modals/NovaCarteiraModal.vue' /* webpackChunkName: "nova-carteira-modal" */),
        },
        methods: {
            showModal() {
                this.$bvModal.show('nova-carteira-modal')
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
