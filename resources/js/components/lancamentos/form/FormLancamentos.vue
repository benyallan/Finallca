<template>
    <div>
        <b-modal 
            id="form-lancamentos" 
            :title="title"
            no-close-on-backdrop
            no-close-on-esc
            hide-header-close
            :header-bg-variant="headerTipo"
            header-text-variant="light"
            @hide="cancelar"
            size="xl"
        >
            <template>
                <b-row>
                    <b-col cols="12" md="6" lg="2">
                        <b-form-group>
                            <label 
                                :style="`color: ${corTipo}`" 
                                for="tipo"
                            >
                                Tipo:
                            </label>
                            <b-form-select 
                                id="tipo"
                                name="tipo"
                                v-model="post.tipo" 
                                :options="tipoOptions"
                                @input="alteraCor"
                                :style="`color: ${corTipo}`"
                                class="form-control form-control-sm"
                                size="sm"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6" lg="7">
                        <b-form-group>
                            <label 
                                for="descricao"
                                :style="`color: ${corTipo}`" 
                            >
                                Descrição:
                            </label>
                            <input
                                id="descricao"
                                v-model="post.descricao"
                                type="text"
                                name="descricao"
                                :style="`color: ${corTipo}`"
                                class="form-control form-control-sm"
                            >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6" lg="3">
                        <b-form-group>
                            <label 
                                for="valorTotal"
                                :style="`color: ${corTipo}`" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipValorTotal"
                            >
                                Valor:
                            </label>
                            <money 
                                id="valorTotal"
                                :style="`color: ${corTipo}`"
                                v-model="post.valorTotal" 
                                v-bind="money"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipValorTotal"
                                class="form-control form-control-sm"
                            ></money>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="12" md="6" lg="3">
                        <b-form-group>
                            <label 
                                for="data"
                                :style="`color: ${corTipo}`" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipData"
                            >
                                Data do lançamento:
                            </label>
                            <input
                                id="data"
                                type="date"
                                :style="`color: ${corTipo}`"
                                v-model="post.data"
                                name="data"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipData"
                                class="form-control form-control-sm"
                            >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6" lg="3">
                        <b-form-group>
                            <label 
                                for="data_vencimento"
                                :style="`color: ${corTipo}`" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipDataVencimento"
                            >
                                Data do vencimento:
                            </label>
                            <input
                                id="data_vencimento"
                                type="date"
                                :style="`color: ${corTipo}`"
                                v-model="post.data_vencimento"
                                name="data_vencimento"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipDataVencimento"
                                class="form-control form-control-sm"
                            >
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group>
                            <label 
                                for="obs"
                                :style="`color: ${corTipo}`" 
                            >
                                Observações:
                            </label>
                            <input
                                id="obs"
                                type="text"
                                v-model="post.obs"
                                name="obs"
                                :style="`color: ${corTipo}`"
                                class="form-control form-control-sm"
                            >
                        </b-form-group>
                    </b-col>
                </b-row>
                <hr>
                <b-row>
                    <div>
                        <b-button 
                            v-b-toggle.dados 
                            :variant="headerTipo"
                        >
                            <b-icon-check2-circle>
                            </b-icon-check2-circle>
                            {{ post.tipo === 'receita' ? 
                                'Receber' : 'Pagar' 
                            }}
                        </b-button>
                        <b-collapse id="dados" class="mt-2">
                            <b-card>
                                <b-row>
                                    <b-col cols="12" md="6" lg="6">
                                        <b-form-group>
                                            <label 
                                                for="valor"
                                                :style="`color: ${corTipo}`" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                :title="tipValor"
                                            >
                                                Valor 
                                                {{ post.tipo === 'receita' ? 
                                                    'Recebido' : 'Pago' 
                                                }}:
                                            </label>
                                            <money 
                                                id="valor"
                                                :style="`color: ${corTipo}`"
                                                v-model="parcela.valor" 
                                                v-bind="money"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                :title="tipValor"
                                                class="form-control form-control-sm"
                                            ></money>
                                        </b-form-group>
                                    </b-col>
                                    <b-col cols="12" md="6" lg="6">
                                        <b-form-group>
                                            <label 
                                                for="data_pagamento"
                                                :style="`color: ${corTipo}`" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                :title="tipDataVencimento"
                                            >
                                                Data que 
                                                {{ post.tipo === 'receita' ? 
                                                    'recebeu o pagamento' 
                                                    : 'pagou a despesa' 
                                                }}:
                                            </label>
                                            <input
                                                id="data_pagamento"
                                                type="date"
                                                :style="`color: ${corTipo}`"
                                                v-model="post.data_pagamento"
                                                name="data_pagamento"
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                :title="tipDataVencimento"
                                                class="form-control form-control-sm"
                                            >
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-form-group>
                                            <label 
                                                for="obsParcela"
                                                :style="`color: ${corTipo}`" 
                                            >
                                                Observações:
                                            </label>
                                            <input
                                                id="obsParcela"
                                                type="text"
                                                v-model="post.obsParcela"
                                                name="obsParcela"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                            >
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-card>
                        </b-collapse>
                    </div>
                </b-row>
            </template>
            <template #modal-footer>
                <b-button
                    @click="$bvModal.hide('form-lancamentos')"
                    class="btn btn-danger"
                >
                    Cancelar
                </b-button>
                <b-button
                    @click="$bvModal.hide('form-lancamentos')"
                    class="btn btn-success px-4"
                >
                    Salvar
                </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import moment from 'moment';
import Mixins from '../../../shared/mixin';
moment.locale('pt-br');

    export default {
        mixins:[Mixins],
        data() {
            return {
                title: null,
                tipValorTotal: null,
                tipValor: null,
                tipData: null,
                tipDataVencimento: null,
                post: {
                    tipo: null,
                    descricao: null,
                    valorTotal: null,
                    data: null,
                    obs: null,
                    obsParcela: null,
                    data_vencimento: null,
                    data_pagamento: null,
                    parcelas: [{
                        valor: null,
                    }]
                },
                parcela: {
                    valor: null,
                },
                corTipo: null,
                headerTipo: null,
                tipoOptions: [
                    { value: "receita", text: "Receita"},
                    { value: "despesa", text: "Despesa"}
                ],
            }
        },
        methods: {
            
            alteraCor(e) {
                if (e === 'receita') {
                    this.corTipo = 'green'
                    this.headerTipo = 'success'
                } else {
                    this.corTipo = 'red'
                    this.headerTipo = 'danger'
                }
            },
            cancelar() {
                this.title = "Adicionar Lançamentos"
                this.post.tipo = 'receita'
                this.post.descricao = null
                this.post.valorTotal = 0
                this.parcela.valor = 0
                this.post.data = moment().format("YYYY-MM-DD")
                this.post.obs = null
                this.post.obsParcela = null
                this.post.data_vencimento = moment().format("YYYY-MM-DD")
                this.post.data_pagamento = moment().format("YYYY-MM-DD")
                this.tipValorTotal = 'Valor esperado para receber'
                this.tipValor = 'Valor esperado para receber '
                    + 'ou que foi realmente recebido'
                this.tipData = 'Data em que foi combinado o valor' 
                    + ' a receber'
                this.tipDataVencimento = 'Data programada para ' 
                    + 'receber o valor'
                this.corTipo = 'green'
                this.headerTipo = 'success'
            }
        },
        mounted () {
            this.cancelar();
        },
    }
</script>

<style lang="scss" scoped>

</style>