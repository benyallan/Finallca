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
            :fields="fields"
            :busy="isBusy"
            :filter="filter"
            :filter-included-fields="filterOn"
            responsive
        >
            <template 
                v-for="(field, index) in fields" 
                    #[`cell(${field.key})`]="data"
            >
                <b-form-input 
                    v-if="field.type === 'text' && 
                        tableItems[data.index].isEdit" 
                    :key="index" 
                    :type="field.type" 
                    :value="tableItems[data.index][field.key]" 
                    @blur="(e) => 
                        inputHandler(e.target.value, data.index, field.key)"
                ></b-form-input>
                <div v-else-if="field.type === 'edit'" :key="index">
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
                </div>
                <span v-else :key="index">{{data.value}}</span>
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

<script>
export default {
    name: "EditableTable",
    components: {},
    props: {
        value: Array,
        fields: Array
    },
    data() {
        return {
            isBusy: false,
            filter: null,
            filterOn: [],
            tableItems: this.value.map(item => ({...item, isEdit: false}))
        }
    },
    methods: {
        editRowHandler(data) {
            this.tableItems[data.index].isEdit = !this.tableItems[data.index].isEdit;
        },
        inputHandler(value, index, key) {
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
      }
    }
};
</script>

<style>
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