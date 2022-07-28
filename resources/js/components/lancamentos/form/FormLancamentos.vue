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
                        <b-collapse id="dados" class="mt-2" v-model="post.pag">
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
                                                {{ post.parcela.tipo === 'receita' ? 
                                                    'Recebido' : 'Pago' 
                                                }}:
                                            </label>
                                            <money 
                                                id="valor"
                                                :style="`color: ${corTipo}`"
                                                v-model="post.parcela.valor" 
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
                                                {{ post.parcela.tipo === 'receita' ? 
                                                    'recebeu o pagamento' 
                                                    : 'pagou a despesa' 
                                                }}:
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
                                                class="form-control form-control-sm"
                                            >
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group>
                                            <label 
                                                for="obsParcela"
                                                :style="`color: ${corTipo}`" 
                                            >
                                                {{post.tipo === 'receita' ? 
                                                'Recabido em' : 'Pago com'}}:
                                            </label>
                                            <b-form-select
                                                id="frmPagamento"
                                                type="text"
                                                v-model="post.formaPagamento"
                                                :options="formasPagamento"
                                                name="frmPagamento"
                                                :style="`color: ${corTipo}`"
                                                class="form-control form-control-sm"
                                            ></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
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
        data() {
            return {
                busy: false,
                title: null,
                tipValorTotal: null,
                tipValor: null,
                tipData: null,
                tipDataVencimento: null,
                showAlert: false,
                messageAlert: '',
                messageErroAlert: '',
                formasPagamento: [{
                    value: null,
                    text: 'Selecione...'
                }],
                post: {
                    descricao: '',
                    valorTotal: null,
                    data: null,
                    obs: null,
                    formaPagamento: null,
                    parcela: {
                        tipo: null,
                        valor: null,
                        data_vencimento: null,
                        data_pagamento: null,
                        numero: 1,
                        total: 1,
                        obs: null,
                        pag: false
                    }
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
                        axios.post('/home/lancamentos', this.post)
                        .then( response => {
                            this.$emit('addLancamento', response.data)
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
                this.tipValorTotal = 'Valor esperado para receber'
                this.tipValor = 'Valor esperado para receber '
                    + 'ou que foi realmente recebido'
                this.tipData = 'Data em que foi combinado o valor' 
                    + ' a receber'
                this.tipDataVencimento = 'Data programada para ' 
                    + 'receber o valor'
                this.corTipo = 'green'
                this.headerTipo = 'success'
                this.post.pag = false
                this.showAlert = false
                this.messageAlert = ''
                this.messageErroAlert = ''
            }
        },
        mounted () {
            this.cancelar();
            axios.get('carteiras/getselect')
            .then( res => {
                res.data.forEach(carteira => {
                    this.formasPagamento.push({
                        value: carteira.id,
                        text: carteira.nome
                    })
                });
            })
        },
    }
</script>

<style lang="scss" scoped>
    
</style>