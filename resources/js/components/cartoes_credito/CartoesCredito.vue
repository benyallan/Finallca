<template>
    <div id="cartoescredito">
        <template>
            <b-container fluid>
                <h1>Cartões de Crédito</h1>
                <b-row>
                    <b-col md="2" lg="2">
                    <b-button 
                        class="add-button d-flex" 
                        variant="success" 
                        @click="addNovaLinha"
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
                >
                    <template #cell(nome)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['nome']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'nome')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(dia_fechamento)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['dia_fechamento']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'dia_fechamento')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(dia_vencimento)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['dia_vencimento']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'dia_vencimento')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(conta_corrente)="data">
                        <b-form-select 
                            v-if="tableItems[data.index].isEdit" 
                            class="form-control"
                            v-model="linha.conta_corrente_id" 
                            :options="options"
                        ></b-form-select>
                        <span v-else>{{data.value.banco}}</span>
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
                        Total de Cartões de Crédito: {{totalLinhas}} 
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
    </div>
</template>

<script>
import axios from 'axios';
import Mixins from '../../shared/mixin';

export default {
    name: "cartoescredito",
    mixins:[Mixins],
    data() {
        return {
            isBusy: false,
            filter: null,
            adicionando: false,
            editando: false,
            linha: {
                nome: null,
                dia_fechamento: null,
                dia_vencimento: null,
                conta_corrente_id: null,
                conta_corrente: {
                    id: null,
                    agencia: null,
                    banco: null,
                    nome: null,
                    numero: null,
                    obs: null
                }
            },
            options: [
                { value: null, text: 'Não vinculado' },
            ],
            filterOn: [],
            totalLinhas: 0,
            tableFields: [
                { key: "nome", label: "Nome", type: 'text', sortable: true },
                { key: "dia_fechamento", label: "Dia de Fechamento", type: 'text', sortable: true },
                { key: "dia_vencimento", label: "Dia de Vencimento", type: 'text', sortable: true },
                { key: "conta_corrente", label: "Conta Corrente", type: 'text', sortable: true },
                { key: "edit", label: "", type: "edit", sortable: false }
            ],
            tableItems: []
        };
    },
    methods: {
        addCartaoCredito(data) {
            axios.post('/home/cartoescredito', this.linha)
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
                this.addCartaoCredito(data)
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
            this.editando = true
            const newRow = this.tableFields.reduce((a, c) => ({...a, [c.key]: null}) ,{})
            newRow.isEdit = true
            this.tableItems.unshift(newRow)
            this.adicionando = true
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
            axios.get('/home/cartoescredito/get')
            .then( response => {
                this.totalLinhas = response.data.length
                this.tableItems = response.data.map(
                    item => ({...item, isEdit: false})
                )
            })
            .catch(function (error) {
                console.log(error);
            })
            axios.get('/home/contascorrente/get/list')
            .then( response => {
                response.data.forEach(contacorrente => {
                    this.options.push({
                        value: contacorrente.id,
                        text: contacorrente.nome + ': ' + 
                            contacorrente.banco
                    })
                });
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
    #cartoescredito {
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