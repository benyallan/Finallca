<template>
    <div class="container">
        <div>
            <b-button v-b-modal.nova-carteira-modal variant="success">Teste de modal</b-button>
        </div>
        <form>
            <div class="row">
                <div class="col-4">
                    <label for="nome">Nome</label>
                    <input type="text"
                        class="form-control" name="nome" id="nome" placeholder="Nome da carteira"
                        v-model="post.nome">
                </div>
                <div class="col-4">
                    <label for="saldo-inicial">Saldo inicial</label>
                    <money id="saldo inicial" name="sald-inicial" class="form-control" v-model="post.saldo_inicial" v-bind="money"></money>
                </div>
                <div class="col-4">
                    <button type="button" @click="addCarteira" class="btn btn-primary my-4">Adicionar carteira</button>
                </div>
            </div>
        </form>

        <b-table striped hover :items="carteiras"></b-table>
        <nova-carteira-modal></nova-carteira-modal>
    </div>
</template>

<script>
    import axios from 'axios'
import {Money} from 'v-money'
    
    export default {
        components: {
            Money,
            NovaCarteiraModal: () => import('./modals/NovaCarteiraModal.vue' /* webpackChunkName: "nova-carteira-modal" */),
        },
        methods: {
            showModal() {
                this.$bvModal.show('nova-carteira-modal')
            },
            addCarteira() {
                let carteira = this.post
                axios.post('/carteiras', this.post)
                .then( response => {
                    this.carteiras.push({
                        nome: response.data.nome,
                        saldo_atual: response.data.saldo_inicial
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });
                
            }
        },
        data () {
            return {
                carteiras: [],
                post: {
                    nome: null,
                    saldo_inicial: 0
                },
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
