<template>
    <div id="contascorrente">
        <template>
            <b-container fluid>
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
                <b-col md="6" lg="6">
                    <b-form-checkbox-group
                        v-model="filterOn"
                        class="mt-1 d-flex"
                    >
                        <b-form-checkbox value="banco" class="m-2">
                            Banco
                        </b-form-checkbox>
                        <b-form-checkbox value="agencia" class="m-2">
                            Agência
                        </b-form-checkbox>
                        <b-form-checkbox value="numero" class="m-2">
                            Conta Corrente
                        </b-form-checkbox>
                    </b-form-checkbox-group>
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
                    <template #cell(banco)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['banco']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'banco')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(agencia)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['agencia']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'agencia')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(numero)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['numero']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'numero')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
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
                    <template #cell(obs)="data">
                        <b-form-input 
                            v-if="tableItems[data.index].isEdit" 
                            type="text" 
                            :value="linha['obs']" 
                            @blur="(e) => 
                                alteraTabela(e.target.value, 'obs')"
                        ></b-form-input>
                        <span v-else>{{data.value}}</span>
                    </template>
                    <template #cell(saldo_inicial)="data">
                        <money 
                            v-model="linha['saldo_inicial']" 
                            v-bind="money"
                            class="form-control"
                            v-if="tableItems[data.index].isEdit"
                        ></money>
                        <span v-else>{{data.value | formatPrice}}</span>
                    </template>
                    <template #cell(edit)="data">
                        <div class="d-flex flex-nowrap">
                            <b-button 
                                v-if="!editando"
                                variant="primary"
                                @click="editarLinha(data)"
                                class="m-1"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Editar"
                            >
                                <b-icon icon="pencil-square"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="editando && tableItems[data.index].isEdit" 
                                variant="success"
                                @click="salvarRegistro(data)"
                                class="m-1"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Salvar"
                            >
                                <b-icon icon="save"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="editando && tableItems[data.index].isEdit" 
                                variant="danger"
                                @click="cancelarAlteracoes(data)"
                                class="m-1"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Cancelar"
                            >
                                <b-icon icon="x-lg"></b-icon>
                            </b-button>
                            <b-button 
                                v-if="!editando"
                                class="delete-button m-1" 
                                variant="danger" 
                                @click="removeLinha(data)"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Apagar"
                            >
                                <b-icon icon="trash"></b-icon>
                            </b-button>
                        </div>
                    </template>
                    <template #table-caption>
                        Total de Contas corrente: {{totalLinhas}} 
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
import {VMoney} from 'v-money'

export default {
    name: "contascorrente",

    mixins:[Mixins],
    data() {
        return {
            isBusy: false,
            filter: null,
            adicionando: false,
            editando: false,
            linha: {
                banco: null,
                agencia: null,
                numero: null,
                nome: null,
                obs: null,
            },
            filterOn: [],
            totalLinhas: 0,
            tableFields: [
                { key: "banco", label: "Banco", type: 'text', sortable: true },
                { key: "agencia", label: "Agência", type: 'text', sortable: false },
                { key: "numero", label: "Número", type: 'text', sortable: false },
                { key: "nome", label: "Titular", type: 'text', sortable: true },
                { key: "obs", label: "Observações", type: 'text', sortable: false },
                { key: "saldo_inicial", label: "Saldo Inicial", type: 'text', sortable: false },
                { key: "edit", label: "", type: "edit", sortable: false }
            ],
            tableItems: []
        };
    },
    methods: {
        addContaCorrente(data) {
            axios.post('/home/contascorrente', this.linha)
            .then( response => {
                this.tableItems[data.index]['banco'] = response.data.banco
                this.tableItems[data.index]['agencia'] = response.data.agencia
                this.tableItems[data.index]['numero'] = response.data.numero
                this.tableItems[data.index]['nome'] = response.data.nome
                this.tableItems[data.index]['obs'] = response.data.obs
                this.tableItems[data.index]['saldo_inicial'] = response.data.saldo_inicial
                this.totalLinhas ++
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        editarLinha(data) {
            this.editando = true
            this.linha['banco'] = this.tableItems[data.index]['banco']
            this.linha['agencia'] = this.tableItems[data.index]['agencia']
            this.linha['numero'] = this.tableItems[data.index]['numero']
            this.linha['nome'] = this.tableItems[data.index]['nome']
            this.linha['obs'] = this.tableItems[data.index]['obs']
            this.linha['saldo_inicial'] = this.tableItems[data.index]['saldo_inicial']
            this.tableItems[data.index].isEdit = true;
        },
        editarRegistro(data) {
            axios.put('/home/contascorrente/' + data.item.id, this.linha)
            .then( response => {
                this.tableItems[data.index]['banco'] = response.data.banco
                this.tableItems[data.index]['agencia'] = response.data.agencia
                this.tableItems[data.index]['numero'] = response.data.numero
                this.tableItems[data.index]['nome'] = response.data.nome
                this.tableItems[data.index]['obs'] = response.data.obs
                this.tableItems[data.index]['saldo_inicial'] = response.data.saldo_inicial
            })
            .catch(function (error) {
                console.log(error);
            })
        },
        salvarRegistro(data) {
            if (this.adicionando) {
                this.addContaCorrente(data)
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
            axios.delete('/home/contascorrente/' + data.item.id)
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
            this.linha.banco = null,
            this.linha.agencia = null,
            this.linha.numero = null,
            this.linha.nome = null,
            this.linha.obs = null,
            this.linha.saldo_inicial = null
        },
        onFiltered(filteredItems) {
            this.totalLinhas = filteredItems.length
        },
        get() {
            this.isBusy = true
            axios.get('/home/contascorrente/get')
            .then( response => {
                this.totalLinhas = response.data.length
                this.tableItems = response.data.map(item => ({...item, isEdit: false}))
            })
            .catch(function (error) {
                console.log(error);
            })
            this.isBusy = false
        }
    },
    mounted() {
        this.get()
    },
    directives: {money: VMoney}
}
</script>

<style>
    #ContasCorrente {
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