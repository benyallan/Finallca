<template>
<div id="ContasCorrente">
    <EditableTable v-model="items" :fields="fields"></EditableTable>
    <pre>
      {{items}}
    </pre>
</div>
</template>

<script>
import EditableTable from '../../Components/EditableTable.vue'
export default {
    name: "ContasCorrente",
    components: {
        EditableTable
    },
    data() {
        return {
        fields: [
            { key: "banco", label: "Banco", type: 'text', sortable: true },
            { key: "agencia", label: "Agência", type: 'text', sortable: false },
            { key: "numero", label: "Número", type: 'text', sortable: false },
            { key: "nome", label: "Nome do titular", type: 'text', sortable: true },
            { key: "obs", label: "Observações", type: 'text', sortable: false },
            { key: "saldo_inicial", label: "Saldo Inicial", type: 'text', sortable: false },
            { key: "edit", label: "", type: "edit", sortable: false }
        ],
        items: [
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
    }
};
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
pre {
  text-align: left;
  color: #d63384 !important;
}
</style>