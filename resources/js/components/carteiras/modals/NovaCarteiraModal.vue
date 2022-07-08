<template>
    <div>
        <b-modal id="nova-carteira-modal" no-close-on-backdrop>
            <template #modal-header="{ close }">
                <h5 class="mt-2 mb-0">Nova Carteira Modal</h5>
                <b-button size="sm" variant="outline-danger" @click="close()">x</b-button>
            </template>

            <template>
                Meio da modal
            </template>

            <template #modal-footer="{ cancel }">
                <b-button size="md" variant="outline-danger" @click="cancel()">
                    Fechar
                </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        methods: {
            showModal() {
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
