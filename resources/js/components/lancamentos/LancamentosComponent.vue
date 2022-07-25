<template>
    <div id="lancamentos">
        <template>
            <b-container fluid>
                <h1>Lançamentos</h1>
                <b-row>
                    <b-col md="2" lg="2">
                    <b-button 
                        class="add-button d-flex" 
                        variant="success" 
                        v-b-modal.form-lancamentos
                    >
                        Adicionar
                    </b-button>
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
                            v-if="data.item.tipo === 'receita'"
                            style="color: green;"
                        >
                            {{data.value | formatPrice}}
                        </span>
                        <span
                            v-else
                            style="color: red;"
                        >
                            {{data.value | formatPrice}}
                        </span>
                    </template>
                    <template #cell(edit)="data">
                        <div class="d-flex flex-nowrap">
                            <b-button 
                                v-if="!editando"
                                variant="primary"
                                @click="editarLinha(data)"
                                class="m-1"
                            >
                                <b-icon icon="pencil-square"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="editando && tableItems[data.index].isEdit" 
                                variant="success"
                                @click="salvarRegistro(data)"
                                class="m-1"
                            >
                                <b-icon icon="save"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="editando && tableItems[data.index].isEdit" 
                                variant="danger"
                                @click="cancelarAlteracoes(data)"
                                class="m-1"
                            >
                                <b-icon icon="x-lg"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="!editando"
                                class="delete-button m-1" 
                                variant="danger" 
                                @click="removeLinha(data)"
                            >
                                <b-icon icon="trash"></b-icon>
                            </b-button>
                        </div>
                    </template>
                    <template #table-caption>
                        <b-row>
                            <b-col sm="4" md="2" class="my-1">
                                Total: {{totalLinhas}} 
                            </b-col>
                            <b-col sm="4" md="5" class="my-1">
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
    
                            <b-col sm="4" md="5" class="my-1">
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
                </b-table>
            </b-container>
        </template>
        <FormLancamentos></FormLancamentos>
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
            editando: false,
            perPage: 10,
            currentPage: 1,
            pageOptions: [5, 10, 15, 100],
            linha: {
                situacao: null,
                data_vencimento: null,
                valor: null,
                conta_corrente_id: null,
                lancamento: {
                    id: null,
                    descricao: null,
                    data: null,
                    obs: null
                },
                forma_pagamento: {
                    forma_pagamento_id: null,
                    forma_pagamento_type: null,
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
                { key: "edit", label: "", type: "edit", sortable: false }
            ],
            tableItems: []
        };
    },
    methods: {
        addLancamento(data) {
            axios.post('/home/lancamentos', this.linha)
            .then( response => {
                this.tableItems[data.index]['nome'] = response.data[0].nome
                this.tableItems[data.index]['dia_fechamento'] = response.data[0].dia_fechamento
                this.tableItems[data.index]['dia_vencimento'] = response.data[0].dia_vencimento
                this.tableItems[data.index]['conta_corrente_id'] = response.data[0].conta_corrente_id
                this.tableItems[data.index]['conta_corrente'] = response.data[0].conta_corrente
                this.totalLinhas ++
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        editarLinha(data) {
            this.editando = true
            this.linha['nome'] = this.tableItems[data.index]['nome']
            this.linha['dia_fechamento'] = this.tableItems[data.index]['dia_fechamento']
            this.linha['dia_vencimento'] = this.tableItems[data.index]['dia_vencimento']
            this.linha['conta_corrente_id'] = this.tableItems[data.index]['conta_corrente_id']
            this.linha['conta_corrente'] = this.tableItems[data.index]['conta_corrente']
            this.tableItems[data.index].isEdit = true;
        },
        editarRegistro(data) {
            axios.put('/home/cartoescredito/' + data.item.id, this.linha)
            .then( response => {
                this.tableItems[data.index]['nome'] = response.data[0].nome
                this.tableItems[data.index]['dia_fechamento'] = response.data[0].dia_fechamento
                this.tableItems[data.index]['dia_vencimento'] = response.data[0].dia_vencimento
                this.tableItems[data.index]['conta_corrente_id'] = response.data[0].conta_corrente_id
                this.tableItems[data.index]['conta_corrente'] = response.data[0].conta_corrente
            })
            .catch(function (error) {
                console.log(error);
            })
        },
        salvarRegistro(data) {
            if (this.adicionando) {
                this.addLancamento(data)
            } else {
                this.editarRegistro(data)
            }
            this.tableItems[data.index].isEdit = false
            this.editando = false
            this.adicionando = false
            this.$emit('input', this.tableItems)
            this.limpaLinha()
        },
        cancelarAlteracoes(data) {
            if (this.adicionando) {
                this.tableItems.shift()
            }
            this.editando = false
            this.tableItems[data.index].isEdit = false
            this.adicionando = false
            this.limpaLinha()
        },
        alteraTabela(value, key) {
            this.linha[key] = value;
            this.$emit("input", this.linha);
        },
        addNovaLinha() {
            //
        },
        removeLinha(data) {
            axios.delete('/home/cartoescredito/' + data.item.id)
            .then(response => {
                this.tableItems = this.tableItems.filter((item, i) => i !== data.index);
                this.$emit('input', this.tableItems);
                this.totalLinhas --
            })
            .catch(function (error) {
                console.log(error);
            })
        },
        limpaLinha() {
            this.linha.nome = null,
            this.linha.dia_fechamento = null,
            this.linha.dia_vencimento = null,
            this.linha.conta_corrente_id = null,
            this.linha.conta_corrente = null
        },
        onFiltered(filteredItems) {
            this.totalLinhas = filteredItems.length
        },
        get() {
            this.isBusy = true
            axios.get('/home/lancamentos/get')
            .then( response => {
                this.totalLinhas = response.data.length
                this.tableItems = response.data.map(
                    item => ({...item, isEdit: false})
                )
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