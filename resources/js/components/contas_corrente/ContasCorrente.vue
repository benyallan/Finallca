<template>
<div id="ContasCorrente">
    <template>
        <article>
            <b-row>
                <b-col cols="2">
                <b-button 
                    class="add-button d-flex" 
                    variant="success" 
                    @click="addNovaLinha"
                >
                    Adicionar
                </b-button>
            </b-col>
            <b-col cols="4">
                <b-input-group size="sm">
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
                            >
                                Limpar
                            </b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-col>
            <b-col cols="6">
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
                    <b-form-input 
                        v-if="tableItems[data.index].isEdit" 
                        type="text" 
                        :value="linha['saldo_inicial']" 
                        @blur="(e) => 
                            alteraTabela(e.target.value, 'saldo_inicial')"
                    ></b-form-input>
                    <span v-else>{{data.value}}</span>
                </template>
                <template #cell(edit)="data">
                    <b-button 
                        v-if="!editando"
                        variant="primary"
                        @click="editarLinha(data)"
                    >
                        Editar
                    </b-button>
                    <b-button 
                        v-if="editando && tableItems[data.index].isEdit" 
                        variant="success"
                        @click="salvarRegistro(data)"
                    >
                        Salvar
                    </b-button>
                    <b-button 
                        v-if="editando && tableItems[data.index].isEdit" 
                        variant="danger"
                        @click="cancelarAlteracoes(data)"
                    >
                        Cancelar
                    </b-button>
                    <b-button 
                        v-if="!editando"
                        class="delete-button" 
                        variant="danger" 
                        @click="removeRowHandler(data.index, !tableItems[data.index].isEdit, data)"
                    >
                        Remover
                    </b-button>
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
        </article>
    </template>
</div>
</template>

<script>
export default {
    name: "ContasCorrente",
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
            tableItems: [
                { 
                    banco: 'Banco do Brasil', 
                    agencia: '492-8', 
                    numero: '4699-X', 
                    nome: 'Beny Allan Rolim Barbosa Olivera e ' +
                            'Carina Rosa de Oliveira Rolim', 
                    obs: 'Conta conjunta',
                    saldo_inicial: 'R$20,00'
                },
                { 
                    banco: 'Bradesco', 
                    agencia: '123-4', 
                    numero: '8888-X', 
                    nome: 'Carina Rosa de Oliveira Rolim', 
                    obs: 'Conta particular',
                    saldo_inicial: 'R$30,00' 
                },
                { 
                    banco: 'Caixa Econômica Federal', 
                    agencia: '456-7', 
                    numero: '9999-0', 
                    nome: 'Beny Allan Rolim Barbosa Olivera', 
                    obs: 'Conta da casa',
                    saldo_inicial: 'R$40,00' 
                },
            ]
        };
    },
    methods: {
        addContaCorrente() {
            axios.post('/contascorrente', this.post)
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
        salvarRegistro(data) {
            this.tableItems[data.index]['banco'] = this.linha['banco']
            this.tableItems[data.index]['agencia'] = this.linha['agencia']
            this.tableItems[data.index]['numero'] = this.linha['numero']
            this.tableItems[data.index]['nome'] = this.linha['nome']
            this.tableItems[data.index]['obs'] = this.linha['obs']
            this.tableItems[data.index]['saldo_inicial'] = this.linha['saldo_inicial']
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
            this.limpaLinha()
        },
        removeRowHandler(index) {
            this.tableItems = this.tableItems.filter((item, i) => i !== index);
        this.$emit('input', this.tableItems);
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
        }
    },
    mounted() {
        this.tableItems = this.tableItems.map(item => ({...item, isEdit: false}));
        this.totalLinhas = this.tableItems.length
    }
}
</script>

<style>
    #ContasCorrente {
    text-align: center;
    margin: 60px;
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
    pre {
        text-align: left;
        color: #d63384;
    }
</style>