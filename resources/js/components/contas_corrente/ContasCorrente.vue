<template>
<div id="ContasCorrente">
    <template>
        <article>
            <b-row>
                <b-col cols="2">
                <b-button 
                    class="add-button d-flex" 
                    variant="success" 
                    @click="addRowHandler"
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
            >
                <template #cell(banco)="data">
                    <b-form-input 
                        v-if="tableItems[data.index].isEdit" 
                        :key="index" 
                        type="text" 
                        :value="tableItems[data.index]['banco']" 
                        @blur="(e) => 
                            alteraTabela(e.target.value, data.index, 'banco')"
                    ></b-form-input>
                    <span v-else>{{data.value}}</span>
                </template>
                <template #cell(edit)="data">
                    <b-button @click="editRowHandler(data)">
                        <span v-if="!tableItems[data.index].isEdit">
                            Editar
                        </span>
                        <span v-else>Salvar</span>
                    </b-button>
                    <b-button 
                        class="delete-button" 
                        variant="danger" 
                        @click="removeRowHandler(data.index, !tableItems[data.index].isEdit, data)"
                    >
                        Remover
                    </b-button>
                </template>
                <template #table-caption>
                    Total de Contas corrente: {{tableItems.length}} 
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
    <pre>
      {{tableItems}}
    </pre>
</div>
</template>

<script>
export default {
    name: "ContasCorrente",
    data() {
        return {
            isBusy: false,
            filter: null,
            filterOn: [],
            tableFields: [
                { key: "banco", label: "Banco", type: 'text', sortable: true },
                { key: "agencia", label: "Agência", type: 'text', sortable: false },
                { key: "numero", label: "Número", type: 'text', sortable: false },
                { key: "nome", label: "Nome do titular", type: 'text', sortable: true },
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
        editRowHandler(data) {
            this.tableItems[data.index].isEdit = !this.tableItems[data.index].isEdit;
        },
        alteraTabela(value, index, key) {
            this.tableItems[index][key] = value;
            this.$set(this.tableItems, index, this.tableItems[index]);
            this.$emit("input", this.tableItems);
        },
        addRowHandler() {
            const newRow = this.fields.reduce((a, c) => ({...a, [c.key]: null}) ,{})
            newRow.isEdit = true;
            this.tableItems.unshift(newRow);
            this.$emit('input', this.tableItems);
        },
        removeRowHandler(index, remover, data) {
            if (remover) {
                this.tableItems = this.tableItems.filter((item, i) => i !== index);
                this.$emit('input', this.tableItems);
            } else {
                this.tableItems[data.index].isEdit = !this.tableItems[data.index].isEdit;
            }
        },
    },
    mounted() {
        this.tableItems = this.tableItems.map(item => ({...item, isEdit: false}));
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