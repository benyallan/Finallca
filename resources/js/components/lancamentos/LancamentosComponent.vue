<template>
    <div id="lancamentos">
        <template>
            <b-container fluid>
                <h1>Lançamentos</h1>
                <b-row>
                    <b-col>
                        <b-button 
                            class="add-button d-flex" 
                            variant="success" 
                            v-b-modal.form-lancamentos
                        >
                            Adicionar lançamento simples
                        </b-button>
                    </b-col>
                    <b-col>
                        <router-link 
                            to="/home/lancamentos/create"
                            class="btn btn-primary"
                            style="color: white;"
                        >
                            Adicionar lançamento parcelado
                        </router-link>
                    </b-col>
                <b-col md="4" lg="4">
                    <b-input-group>
                        <b-form-input
                            id="filter-input"
                            v-model="filter"
                            type="search"
                            placeholder="Pesquisar"
                        ></b-form-input>
                        <b-input-group-append>
                                <b-button 
                                    :disabled="!filter" 
                                    @click="filter = ''"
                                    variant="outline-secondary"
                                >
                                    <b-icon icon="backspace"></b-icon>
                                </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
                </b-row>
                <b-table 
                    id="tbl-lancamentos"
                    name="tbl-lancamentos"
                    class="b-table" 
                    :items="tableItems" 
                    :fields="tableFields"
                    :busy="isBusy"
                    :filter="filter"
                    :filter-included-fields="filterOn"
                    responsive
                    @filtered="onFiltered"
                    :per-page="perPage"
                    :current-page="currentPage"
                    show-empty
                >
                    <template #cell(situacao)="data">
                        <div class="d-flex justify-content-center">
                            <b-icon-check-circle-fill
                                v-if="data.value === 'Pago'"
                                style="
                                    color: green; 
                                    height: 2em; 
                                    width: 2em;
                                "
                            >
                            </b-icon-check-circle-fill>
                            <b-icon-dash-circle-fill
                                v-if="data.value === 'Em Atraso'"
                                style="
                                    color: red; 
                                    height: 2em; 
                                    width: 2em;
                                "
                            >
                            </b-icon-dash-circle-fill>
                        </div>
                    </template>
                    <template #cell(lancamento)="data">
                        <span>{{data.value.descricao}}</span>
                    </template>
                    <template #cell(data_vencimento)="data">
                        <span>{{data.value | momentDate }}</span>
                    </template>
                    <template #cell(valor)="data">
                        <span
                            :style="`color: ${
                                data.item.tipo === 'receita'
                                    ? 'green'
                                    : 'red'
                            };`"
                        >
                            {{data.value | formatPrice}}
                        </span>
                    </template>
                    <template #cell(forma_pagamento)="data">
                        <span>{{data.value.identificador}}</span>
                    </template>
                    <template #cell(acoes)="row">
                        <div class="d-flex flex-nowrap">
                            <b-button 
                                variant="primary"
                                @click="row.toggleDetails"
                                class="m-1"
                            >
                                <b-icon icon="eye"></b-icon>
                            </b-button>
                            <b-button 
                                class="delete-button m-1" 
                                variant="danger" 
                                @click=""
                            >
                                <b-icon icon="trash"></b-icon>
                            </b-button>
                        </div>
                    </template>
                    <template #row-details="row">
                        <b-card :title="row.item.situacao">
                            <b-row
                                class="mb-2"
                                v-if="row.item.total > 1"
                            >
                                <b-col>
                                    <strong>Valor da parcela: </strong>
                                    <span
                                        :style="`color: ${
                                            row.item.tipo === 'receita'
                                                ? 'green'
                                                : 'red'
                                        };`"
                                    >
                                        {{ row.item.valor | formatPrice }}
                                    </span>
                                </b-col>
                                <b-col>
                                    <strong>Valor total: </strong>
                                    <span
                                        :style="`color: ${
                                            row.item.tipo === 'receita'
                                                ? 'green'
                                                : 'red'
                                        };`"
                                    >
                                    {{ row.item.lancamento.valorTotal
                                        | formatPrice }}
                                    </span>
                                </b-col>
                                <b-col>
                                    <strong>Parcela: </strong>
                                    {{ row.item.numero }}
                                    /
                                    {{ row.item.total }}
                                </b-col>
                            </b-row>
                            <b-row 
                                class="mb-2"
                                v-if="row.item.total === 1"
                            >
                                <b-col>
                                    <strong>Valor: </strong>
                                    <span
                                        :style="`color: ${
                                            row.item.tipo === 'receita'
                                                ? 'green'
                                                : 'red'
                                        };`"
                                    >
                                    {{ row.item.lancamento.valorTotal
                                        | formatPrice }}
                                    </span>
                                </b-col>
                            </b-row>
                            <b-row class="mb-2">
                                <b-col>
                                    {{ row.item.lancamento.descricao }}
                                </b-col>
                            </b-row>
                            <b-row class="mb-2">
                                <b-col>
                                    <strong>Data da compra:</strong>
                                    {{ row.item.lancamento.data | momentDate }}
                                </b-col>
                                <b-col
                                    v-if="row.item.data_vencimento != row.item.lancamento.data"
                                >
                                    <strong>Data do vencimento:</strong>
                                    {{ row.item.data_vencimento | momentDate }}
                                </b-col>
                                <b-col v-if="row.item.data_pagamento">
                                    <strong>Data do pagamento:</strong>
                                    {{ row.item.data_pagamento | momentDate }}
                                </b-col>
                            </b-row>
                            <b-row class="mb-2" col v-if="row.item.data_pagamento">
                                <b-col>
                                    <strong>Pagamento:</strong>
                                    {{ row.item.forma_pagamento.identificador }}
                                </b-col>
                            </b-row>
                            <b-row class="mb-2" col v-if="row.item.data_pagamento">
                                <b-col>
                                    <strong>Pago com:</strong>
                                    {{ row.item.forma_pagamento.tipo }}
                                </b-col>
                                <b-col>
                                    <strong>De: </strong>
                                    {{ row.item.forma_pagamento.nome }}
                                </b-col>
                            </b-row>
                        </b-card>
                    </template>
                    <template #table-caption="data">
                        <b-row v-if="!data.empty">
                            <b-col sm="4" md="2" class="my-1">
                                Total: {{totalLinhas}} 
                            </b-col>
                            <b-col 
                                sm="4" md="5" class="my-1"
                                v-if="totalLinhas > 5"
                            >
                                <b-row>
                                    <b-col cols="4">
                                        <span>
                                            Lançamentos por página:
                                        </span>
                                    </b-col>
                                    <b-col cols="8">
                                        <b-form-select
                                            id="per-page-select"
                                            v-model="perPage"
                                            :options="pageOptions"
                                            class="form-control"
                                        ></b-form-select>
                                    </b-col>
                                </b-row>
                            </b-col>
    
                            <b-col 
                                sm="4" md="5" class="my-1"
                                v-if="totalLinhas > perPage"
                            >
                                <b-pagination
                                v-model="currentPage"
                                :total-rows="totalLinhas"
                                :per-page="perPage"
                                align="fill"
                                size="sm"
                                class="my-0"
                                ></b-pagination>
                            </b-col>
                        </b-row>
                    </template>
                    <template #table-busy>
                        <div class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Carregando...</strong>
                        </div>
                    </template>
                    <template #empty="scope">
                        <h4 class="text-center">Não há lançamentos</h4>
                    </template>
                    <template #emptyfiltered="scope">
                        <h4 class="text-center">Sem lançamentos com este filtro</h4>
                    </template>
                </b-table>
            </b-container>
        </template>
        <FormLancamentos @addLancamento="addLancamento"></FormLancamentos>
    </div>
</template>

<script>
import axios from 'axios';
import Mixins from '../../shared/mixin';
import FormLancamentos from './form/FormLancamentos.vue';

export default {
    name: "lancamentos",
    mixins:[Mixins],
    components: {
        FormLancamentos,
    },
    data() {
        return {
            isBusy: false,
            filter: null,
            adicionando: false,
            perPage: 10,
            currentPage: 1,
            pageOptions: [5, 10, 15, 100],
            linha: {
                situacao: null,
                data_vencimento: null,
                data_pagamento: null,
                valor: null,
                forma_pagamento: null,
                lancamento: {
                    id: null,
                    descricao: null,
                    data: null,
                    valorTotal: null,
                    obs: null
                }
            },
            options: [
                { value: null, text: 'Não vinculado' },
            ],
            filterOn: [],
            totalLinhas: 0,
            tableFields: [
                { key: "situacao", label: "Situação", type: 'text', sortable: true },
                { key: "data_vencimento", label: "Data", type: 'date', sortable: true },
                { key: "lancamento", label: "Descrição", type: 'text', sortable: true },
                { key: "valor", label: "Valor", type: 'text', sortable: true },
                { key: "forma_pagamento", label: "Pagamento", type: 'text', sortable: true },
                { key: "acoes", label: "", type: "acoes", sortable: false }
            ],
            tableItems: []
        };
    },
    methods: {
        addLancamento(data) {
            let newRow = {
                situacao: null,
                data_vencimento: null,
                data_pagamento: null,
                valor: null,
                forma_pagamento: null,
                lancamento: {
                    id: null,
                    descricao: null,
                    data: null,
                    valorTotal: null,
                    obs: null
                }
            }
            newRow.lancamento.data = data.data
            newRow.lancamento.descricao = data.descricao
            newRow.lancamento.valorTotal = data.valorTotal
            newRow.lancamento.obs = data.obs
            newRow.data_pagamento = data.parcela[0].data_pagamento
            newRow.data_vencimento = data.parcela[0].data_vencimento
            newRow.situacao = data.parcela[0].situacao
            newRow.valor = data.parcela[0].valor
            newRow.situacao = data.parcela[0].situacao
            newRow.numero = data.parcela[0].numero
            newRow.tipo = data.parcela[0].tipo
            newRow.total = data.parcela[0].total
            newRow.forma_pagamento = data.parcela[0].forma_pagamento
            this.tableItems.unshift(newRow)
        },
        limpaLinha() {
            this.linha.lancamento.data = null
            this.linha.lancamento.descricao = null
            this.linha.lancamento.valorTotal = null
            this.linha.lancamento.obs = null
            this.linha.data_pagamento = null
            this.linha.data_vencimento = null
            this.linha.situacao = null
            this.linha.valor = null
            this.linha.situacao = null
            this.linha.numero = null
            this.linha.tipo = null
            this.linha.total = null
            this.linha.forma_pagamento = null
        },
        onFiltered(filteredItems) {
            this.totalLinhas = filteredItems.length
        },
        async get() {
            this.isBusy = true
            await axios.get('/home/lancamentos/get')
            .then( response => {
                this.totalLinhas = response.data.length
                this.tableItems = response.data
            })
            .catch(function (error) {
                console.log(error);
            })
            this.isBusy = false
        }
    },
    mounted() {
        this.get()
    }
}
</script>

<style>
    #lancamentos {
    text-align: center;
    margin: 10px;
    }
    thead, tbody, tfoot, tr, td, th {
    text-align: left;
    width: 100px;
    vertical-align: middle;
    }
    .add-button {
        margin-bottom: 10px;
    }
    span.sr-only {
        display:none;
    }
    label.custom-control-label {
        padding-left: 5px;
    }
</style>