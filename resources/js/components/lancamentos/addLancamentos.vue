<template>
    <div id="add-lancamentos">
        <template>
            <b-container fluid>
                <h1>Adicionar Receita</h1>
                <b-alert v-model="showAlert" variant="danger">
                    <p>{{ messageAlert }}</p>
                    <hr v-if="!messageErroAlert === ''">
                    <p>{{ messageErroAlert }}</p>
                </b-alert>
                <template v-if="!busy">
                    <b-row>
                        <b-col cols="12" md="6" lg="6">
                            <b-form-group>
                                <label 
                                    for="descricao"
                                >
                                    Descrição:
                                </label>
                                <input
                                    id="descricao"
                                    v-model="post.descricao"
                                    type="text"
                                    name="descricao"
                                    :state="false"
                                    trim
                                    v-validate="{ required: true }"
                                    data-vv-as="descrição"
                                    :class="['form-control form-control-sm', 
                                        {'is-invalid': errors.has('descricao')}]"
                                >
                                <span v-show="errors.has('descricao')" class="invalid-feedback">
                                    {{ errors.first('descricao') }}
                                </span>
                            </b-form-group>
                        </b-col>
                        <b-col cols="12" md="6" lg="3">
                            <b-form-group>
                                <label 
                                    for="valorTotal"
                                >
                                    Valor:
                                </label>
                                <money 
                                    id="valorTotal"
                                    name="valorTotal"
                                    style="color: green;"
                                    v-model="post.valorTotal" 
                                    v-bind="money"
                                    v-validate="'min_value:0.01'"
                                    data-vv-as="valor"
                                    :class="['form-control form-control-sm', 
                                        {'is-invalid': errors.has('valorTotal')}]"
                                ></money>
                                <span v-show="errors.has('valorTotal')" class="invalid-feedback">
                                    {{ errors.first('valorTotal') }}
                                </span>
                            </b-form-group>
                        </b-col>
                        <b-col cols="12" md="6" lg="3">
                            <b-form-group>
                                <label 
                                    for="data"
                                >
                                    Data:
                                </label>
                                <input
                                    id="data"
                                    type="date"
                                    v-model="post.data"
                                    name="data"
                                    class="form-control form-control-sm"
                                    v-validate="{ required: true }"
                                    data-vv-as="data"
                                    :class="['form-control form-control-sm', 
                                        {'is-invalid': errors.has('data')}]"
                                >
                                <span v-show="errors.has('data')" class="invalid-feedback">
                                    {{ errors.first('data') }}
                                </span>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-form-group>
                                <label 
                                    for="obs"
                                >
                                    Observações:
                                </label>
                                <input
                                    id="obs"
                                    type="text"
                                    v-model="post.obs"
                                    name="obs"
                                    class="form-control form-control-sm"
                                >
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col class="my-3">
                            <b-card no-body>
                                <b-tabs v-model="tabIndex" card>
                                    <b-tab title="Não recebido" :title-link-class="linkClass(0)">
                                        <b-row class="mt-2">
                                            <b-col>
                                                Ainda não foi recebido
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                                    <b-tab title="Receber" :title-link-class="linkClass(1)">
                                        <b-row class="mt-2">
                                            <b-col md="6" lg="3">
                                                <b-form-group>
                                                    <label 
                                                        for="frmPagamento"
                                                    >
                                                        Recebido em:
                                                    </label>
                                                    <b-form-select
                                                        id="frmPagamento"
                                                        v-model="post.formaPagamento.classe"
                                                        :options="formasPagamento"
                                                        name="frmPagamento"
                                                        class="form-control form-control-sm"
                                                        v-validate="{ required: tabIndex === 1 }"
                                                        data-vv-as="forma de pagamento"
                                                        :class="['form-control form-control-sm', 
                                                            {'is-invalid': errors.has('frmPagamento')}]"
                                                    ></b-form-select>
                                                    <span v-show="errors.has('frmPagamento')" class="invalid-feedback">
                                                        {{ errors.first('frmPagamento') }}
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'carteira'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcCarteira"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcCarteira"
                                                        v-model="post.formaPagamento.id"
                                                        :options="carteiras"
                                                        text-field="nome"
                                                        value-field="id"
                                                        :state="sttCarteira"
                                                        name="opcCarteira"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttCarteira===false" class="invalid-feedback">
                                                        Carteira não pode ser nula
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'conta corrente'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcContaCorrente"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcContaCorrente"
                                                        v-model="post.formaPagamento.id"
                                                        :options="contascorrente"
                                                        name="opcContaCorrente"
                                                        :state="sttContaCorrente"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttContaCorrente===false" class="invalid-feedback">
                                                        Conta Corrente não pode ser nula
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'cartao credito'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcCartaoCredito"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcCartaoCredito"
                                                        v-model="post.formaPagamento.id"
                                                        :options="cartoescredito"
                                                        text-field="nome"
                                                        value-field="id"
                                                        :state="sttCartaoCredito"
                                                        name="opcCartaoCredito"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttCartaoCredito===false" class="invalid-feedback">
                                                        Cartão de Crédito não pode ser nulo
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col cols="12" md="6" lg="3">
                                                <b-form-group>
                                                    <label 
                                                        for="valor"
                                                    >
                                                        Valor recebido:
                                                    </label>
                                                    <money 
                                                        id="valor"
                                                        name="valor"
                                                        style="color: green;"
                                                        v-model="post.valor" 
                                                        v-bind="money"
                                                        v-validate="'min_value:0.01'"
                                                        data-vv-as="valor"
                                                        :class="['form-control form-control-sm', 
                                                            {'is-invalid': errors.has('valor')}]"
                                                    ></money>
                                                    <span v-show="errors.has('valor')" class="invalid-feedback">
                                                        {{ errors.first('valor') }}
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                                    <b-tab title="Receber Depois" :title-link-class="linkClass(2)">
                                        <b-row class="mt-2">
                                            <b-col md="6" lg="3">
                                                <b-form-group>
                                                    <label 
                                                        for="frmPagamento"
                                                    >
                                                        Recebido em:
                                                    </label>
                                                    <b-form-select
                                                        id="frmPagamento"
                                                        v-model="post.formaPagamento.classe"
                                                        :options="formasPagamento"
                                                        name="frmPagamento"
                                                        class="form-control form-control-sm"
                                                        v-validate="{ required: tabIndex === 2 }"
                                                        data-vv-as="forma de pagamento"
                                                        :class="['form-control form-control-sm', 
                                                            {'is-invalid': errors.has('frmPagamento')}]"
                                                    ></b-form-select>
                                                    <span v-show="errors.has('frmPagamento')" class="invalid-feedback">
                                                        {{ errors.first('frmPagamento') }}
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'carteira'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcCarteira"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcCarteira"
                                                        v-model="post.formaPagamento.id"
                                                        :options="carteiras"
                                                        text-field="nome"
                                                        value-field="id"
                                                        :state="sttCarteira"
                                                        name="opcCarteira"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttCarteira===false" class="invalid-feedback">
                                                        Carteira não pode ser nula
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'conta corrente'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcContaCorrente"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcContaCorrente"
                                                        v-model="post.formaPagamento.id"
                                                        :options="contascorrente"
                                                        name="opcContaCorrente"
                                                        :state="sttContaCorrente"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttContaCorrente===false" class="invalid-feedback">
                                                        Conta Corrente não pode ser nula
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col 
                                                lg="6"
                                                v-show="post.formaPagamento.classe === 'cartao credito'"
                                            >
                                                <b-form-group>
                                                    <label 
                                                        for="opcCartaoCredito"
                                                    >
                                                        Escolha qual:
                                                    </label>
                                                    <b-form-select
                                                        id="opcCartaoCredito"
                                                        v-model="post.formaPagamento.id"
                                                        :options="cartoescredito"
                                                        text-field="nome"
                                                        value-field="id"
                                                        :state="sttCartaoCredito"
                                                        name="opcCartaoCredito"
                                                        class="form-control form-control-sm"
                                                    >
                                                        <template #first>
                                                            <b-form-select-option :value="null" disabled>
                                                                -- Selecione... --
                                                            </b-form-select-option>
                                                        </template>
                                                    </b-form-select>
                                                    <span v-show="sttCartaoCredito===false" class="invalid-feedback">
                                                        Cartão de Crédito não pode ser nulo
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                            <b-col cols="12" md="6" lg="3">
                                                <b-form-group>
                                                    <label 
                                                        for="valor"
                                                    >
                                                        Valor recebido:
                                                    </label>
                                                    <money 
                                                        id="valor"
                                                        name="valor"
                                                        style="color: green;"
                                                        v-model="post.valor" 
                                                        v-bind="money"
                                                        v-validate="'min_value:0.01'"
                                                        data-vv-as="valor"
                                                        :class="['form-control form-control-sm', 
                                                            {'is-invalid': errors.has('valor')}]"
                                                    ></money>
                                                    <span v-show="errors.has('valor')" class="invalid-feedback">
                                                        {{ errors.first('valor') }}
                                                    </span>
                                                </b-form-group>
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                                    <b-tab title="Receber Parcelado" :title-link-class="linkClass(3)">
                                        <b-row class="mt-2">
                                            <b-col>
                                                Receber Parcelado
                                            </b-col>
                                        </b-row>
                                    </b-tab>
                                </b-tabs>
                            </b-card>
                        </b-col>
                    </b-row>
                    <hr>
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
                                    v-model="post.parcela.data_vencimento"
                                    name="data_vencimento"
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    :title="tipDataVencimento"
                                    class="form-control form-control-sm"
                                    v-validate="{ required: true }"
                                    data-vv-as="data do vencimento"
                                    :class="['form-control form-control-sm', 
                                        {'is-invalid': errors.has('data_vencimento')}]"
                                >
                                <span v-show="errors.has('data_vencimento')" class="invalid-feedback">
                                    {{ errors.first('data_vencimento') }}
                                </span>
                            </b-form-group>
                        </b-col>
                    <b-row>
                        <div>
                            <b-button 
                                v-b-toggle.dados 
                                :variant="headerTipo"
                            >
                                <b-icon-check2-circle>
                                </b-icon-check2-circle>
                                {{ post.parcela.tipo === 'receita' ? 
                                    'Receber' : 'Pagar' 
                                }}
                            </b-button>
                            <b-collapse id="dados" class="mt-2" v-model="post.quitado">
                                <b-card>
                                    <b-row>
                                        <b-col cols="12" md="6" lg="3">
                                            <b-form-group>
                                                <label 
                                                    for="data_pagamento"
                                                    :style="`color: ${corTipo}`" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    :title="tipDataVencimento"
                                                >
                                                    Foi quitado em:
                                                </label>
                                                <input
                                                    id="data_pagamento"
                                                    type="date"
                                                    :style="`color: ${corTipo}`"
                                                    v-model="post.parcela.data_pagamento"
                                                    name="data_pagamento"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    :title="tipDataVencimento"
                                                    v-validate="{ required: post.quitado }"
                                                    data-vv-as="forma de pagamento"
                                                    :class="['form-control form-control-sm', 
                                                        {'is-invalid': errors.has('data_pagamento')}]"
                                                >
                                                <span v-show="errors.has('data_pagamento')" class="invalid-feedback">
                                                    {{ errors.first('data_pagamento') }}
                                                </span>
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
                                                    v-model="post.parcela.obs"
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
                <template v-else>
                    <div class="text-center text-primary my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Salvando...</strong>
                    </div>
                </template>
                <template #modal-footer>
                    <b-button
                        @click="$bvModal.hide('form-lancamentos')"
                        class="btn btn-danger"
                    >
                        Cancelar
                    </b-button>
                    <b-button
                        @click="salvar"
                        class="btn btn-success px-4"
                    >
                        Salvar
                    </b-button>
                </template>
            </b-container>
        </template>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Mixins from '../../shared/mixin';
moment.locale('pt-br');

    export default {
        mixins:[Mixins],
        watch: {
            "post.formaPagamento.classe": function () {
                this.post.formaPagamento.id = null
            },
            "post.quitado": function () {
                this.post.parcela.data_pagamento = null
                this.post.parcela.valor = 0
                this.post.parcela.obs = null
                this.post.formaPagamento.id = null
                this.post.formaPagamento.classe = null
            }
        },
        computed: {
            tipValorTotal() {
                if (this.post.parcela.tipo === 'receita') {
                    return 'Valor esperado para receber'
                } else {
                    return 'Valor da dívida'
                }
            },
            tipData() {
                if (this.post.parcela.tipo === 'receita') {
                    return 'Data em que foi combinado o valor'
                        + ' a receber'
                } else {
                    return 'Data em que foi combinado o valor'
                        + ' a pagar'
                }
            },
            tipDataVencimento() {
                if (this.post.parcela.tipo === 'receita') {
                    return 'Data que realmente foi recebido' 
                } else {
                    return 'Data que realmente foi pago' 
                }
            }
        },
        data() {
            return {
                busy: false,
                title: null,
                showAlert: false,
                sttCarteira: null,
                sttContaCorrente: null,
                sttCartaoCredito: null,
                messageAlert: '',
                messageErroAlert: '',
                formasPagamento: [
                    { value: null, text: 'Selecione...' },
                    { value: "carteira", text: 'Carteira' },
                    { value: "cartao credito", text: 'Cartão de crédito' },
                    { value: "conta corrente", text: 'Conta Corrente' }
                ],
                carteiras:null,
                contascorrente: [],
                cartoescredito: null,
                post: {
                    descricao: '',
                    valorTotal: null,
                    data: null,
                    obs: null,
                    formaPagamento: {
                        id: null,
                        classe: null
                    },
                    parcela: {
                        tipo: null,
                        valor: null,
                        data_vencimento: null,
                        data_pagamento: null,
                        numero: 1,
                        total: 1,
                        obs: null,
                    },
                    quitado: false
                },
                corTipo: null,
                headerTipo: null,
                tipoOptions: [
                    { value: "receita", text: "Receita"},
                    { value: "despesa", text: "Despesa"}
                ],
                tabIndex: 0
            }
        },
        methods: {
            linkClass(idx) {
                if (this.tabIndex === idx) {
                    return ['bg-primary', 'text-light']
                } else {
                    return ['bg-light', 'text-info']
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    h1 {
    text-align: center;
    margin: 10px;
    }
    thead, tbody, tfoot, tr, td, th {
    text-align: left;
    width: 100px;
    vertical-align: middle;
    }
    span.sr-only {
        display:none;
    }
</style>