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

        <b-table 
            striped hover 
            :items="tabela.items"
            :fields="tabela.fields"
        >
        <template #cell(nome)="data">
            <b-form-input 
                v-if="tabela.items[data.index].isEdit" 
                type="text" v-model="tabela.items[data.index].nome">
            </b-form-input>
            <span v-else>{{data.value}}</span>
        </template>
        <template #cell(saldo_inicial)="data">
            <b-form-input 
                v-if="tabela.items[data.index].isEdit" 
                type="text" v-model="tabela.items[data.index].saldo_inicial">
            </b-form-input>
            <span v-else>{{data.value}}</span>
        </template>
        <template #cell(acoes)="data">
            <b-button @click="editRowHandler(data)" variant="primary">
                <span v-if="!tabela.items[data.index].isEdit">Editar</span>
                <span v-else>Salvar</span>
            </b-button>
            <b-button variant="danger">Delete</b-button>
        </template>
        </b-table>
         <pre>
            {{ tabela.items }}
        </pre>
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
                axios.post('/carteiras', this.post)
                .then( response => {
                    this.tabela.items.splice(0,0,{
                        nome: response.data.nome,
                        saldo_inicial: response.data.saldo_inicial
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editRowHandler(data) {
                this.tabela.items[data.index].isEdit = 
                    !this.tabela.items[data.index].isEdit;
            }
        },
        data () {
            return {
                carteiras: [],
                post: {
                    nome: null,
                    saldo_inicial: 0
                },
                tabela: {
                    fields: [
                            {key: 'nome', label: 'Nome'},
                            {key: 'saldo_inicial', label: 'Saldo Inicial'},
                            {key: 'acoes', label: 'Ações'}
                        ],
                    items: [],
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
        },
        mounted() {
            axios.get('/carteiras/get').then(response => {
                response.data.forEach( item => {
                    this.tabela.items.push({
                        nome: item.nome,
                        saldo_inicial: item.saldo_inicial,
                        isEdit: false
                    })
                })
            })
        }
    }
</script>
