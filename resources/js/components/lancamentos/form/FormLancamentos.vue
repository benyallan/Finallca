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
        <b-alert v-model="showAlert" variant="danger">
            <p>{{ messageAlert }}</p>
            <hr v-if="!messageErroAlert === ''">
            <p>{{ messageErroAlert }}</p>
        </b-alert>
            <template v-if="!busy">
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
                                v-model="post.parcela.tipo" 
                                :options="tipoOptions"
                                @input="alteraCorTela"
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
                                :state="false"
                                :style="`color: ${corTipo}`"
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
                                :style="`color: ${corTipo}`" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                :title="tipValorTotal"
                            >
                                Valor:
                            </label>
                            <money 
                                id="valorTotal"
                                name="valorTotal"
                                :style="`color: ${corTipo}`"
                                v-model="post.valorTotal" 
                                v-bind="money"
                                data-toggle="tooltip" 
                                data-placement="top" 
                                v-validate="'min_value:0.01'"
                                data-vv-as="valor"
                                :title="tipValorTotal"
                                :class="['form-control form-control-sm', 
                                    {'is-invalid': errors.has('valorTotal')}]"
                            ></money>
                            <span v-show="errors.has('valorTotal')" class="invalid-feedback">
                                {{ errors.first('valorTotal') }}
                            </span>
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
                                    <b-col md="6" lg="3">
                                        <b-form-group>
                                            <label 
                                                for="frmPagamento"
                                                :style="`color: ${corTipo}`" 
                                            >
                                                {{post.parcela.tipo === 'receita' ? 
                                                'Recebido em' : 'Pago com'}}:
                                            </label>
                                            <b-form-select
                                                id="frmPagamento"
                                                v-model="post.formaPagamento.classe"
                                                :options="formasPagamento"
                                                name="frmPagamento"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                                v-validate="{ required: post.quitado }"
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
                                                :style="`color: ${corTipo}`" 
                                            >
                                                Escolha qual:
                                            </label>
                                            <b-form-select
                                                id="opcCarteira"
                                                v-model="post.formaPagamento.id"
                                                :options="carteiras"
                                                text-field="nome"
                                                value-field="id"
                                                name="opcCarteira"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                            >
                                                <template #first>
                                                    <b-form-select-option :value="null" disabled>
                                                        -- Selecione... --
                                                    </b-form-select-option>
                                                </template>
                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col 
                                        lg="6"
                                        v-show="post.formaPagamento.classe === 'conta corrente'"
                                    >
                                        <b-form-group>
                                            <label 
                                                for="opcContaCorrente"
                                                :style="`color: ${corTipo}`" 
                                            >
                                                Escolha qual:
                                            </label>
                                            <b-form-select
                                                id="opcContaCorrente"
                                                v-model="post.formaPagamento.id"
                                                :options="contascorrente"
                                                name="opcContaCorrente"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                            >
                                                <template #first>
                                                    <b-form-select-option :value="null" disabled>
                                                        -- Selecione... --
                                                    </b-form-select-option>
                                                </template>
                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col 
                                        lg="6"
                                        v-show="post.formaPagamento.classe === 'cartao credito'"
                                    >
                                        <b-form-group>
                                            <label 
                                                for="opcCartaoCredito"
                                                :style="`color: ${corTipo}`" 
                                            >
                                                Escolha qual:
                                            </label>
                                            <b-form-select
                                                id="opcCartaoCredito"
                                                v-model="post.formaPagamento.id"
                                                :options="cartoescredito"
                                                text-field="nome"
                                                value-field="id"
                                                name="opcCartaoCredito"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                            >
                                                <template #first>
                                                    <b-form-select-option :value="null" disabled>
                                                        -- Selecione... --
                                                    </b-form-select-option>
                                                </template>
                                            </b-form-select>
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
        </b-modal>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Mixins from '../../../shared/mixin';
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
            }
        },
        methods: {
            salvar() {
                this.$validator.validate().then((valid) => {
                    if (valid) {
                        this.busy = true
                        // Necessário por causa do Backend
                        this.post.parcela.valor = this.post.valorTotal
                        axios.post('/home/lancamentos', this.post)
                        .then( response => {
                            this.$emit('addLancamento', response.data)
                            this.cancelar()
                            this.busy = false
                        })
                        .catch(error => {
                            this.messageAlert = "Erro ao tentar salvar"
                            this.messageErroAlert = error
                            this.showAlert = true
                        })
                    } else {
                        this.showAlert = true
                        this.messageAlert = 'Preencha os campos corretamente'
                    }
                    
                })
            },
            alteraCorTela(e) {
                if (e === 'receita') {
                    this.corTipo = 'green'
                    this.headerTipo = 'success'
                } else {
                    this.corTipo = 'red'
                    this.headerTipo = 'danger'
                }
            },
            cancelar() {
                this.busy = false
                this.title = "Adicionar Lançamentos"
                this.post.parcela.tipo = 'receita'
                this.post.descricao = ''
                this.post.valorTotal = 0
                this.post.parcela.valor = 0
                this.post.data = moment().format("YYYY-MM-DD")
                this.post.obs = null
                this.post.parcela.obs = null
                this.post.parcela.data_vencimento = moment().format("YYYY-MM-DD")
                this.post.parcela.data_pagamento = null
                this.post.formaPagamento.id = null,
                this.post.formaPagamento.classe = null,
                this.corTipo = 'green'
                this.headerTipo = 'success'
                this.post.quitado = false
                this.showAlert = false
                this.messageAlert = ''
                this.messageErroAlert = ''
            }
        },
        mounted () {
            this.cancelar();
            axios.get('carteiras/get/list')
            .then( res => {
                this.carteiras = res.data
            })
            axios.get('cartoescredito/get/list')
            .then( res => {
                this.cartoescredito = res.data
            })
            axios.get('contascorrente/get/list')
            .then( res => {
                res.data.forEach(contacorrente => {
                    this.contascorrente.push({
                        value: contacorrente.id,
                        text: `${contacorrente.nome}: 
                            ${contacorrente.banco}`
                    })
                })
            })
        },
    }
</script>

<style lang="scss" scoped>
    
</style>