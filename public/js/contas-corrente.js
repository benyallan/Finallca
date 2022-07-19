"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["contas-corrente"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ContasCorrente",
  data: function data() {
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
        obs: null
      },
      filterOn: [],
      totalLinhas: 0,
      tableFields: [{
        key: "banco",
        label: "Banco",
        type: 'text',
        sortable: true
      }, {
        key: "agencia",
        label: "Agência",
        type: 'text',
        sortable: false
      }, {
        key: "numero",
        label: "Número",
        type: 'text',
        sortable: false
      }, {
        key: "nome",
        label: "Titular",
        type: 'text',
        sortable: true
      }, {
        key: "obs",
        label: "Observações",
        type: 'text',
        sortable: false
      }, {
        key: "saldo_inicial",
        label: "Saldo Inicial",
        type: 'text',
        sortable: false
      }, {
        key: "edit",
        label: "",
        type: "edit",
        sortable: false
      }],
      tableItems: []
    };
  },
  methods: {
    addContaCorrente: function addContaCorrente(data) {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default().post('/contascorrente', this.linha).then(function (response) {
        _this.tableItems[data.index]['banco'] = response.data.banco;
        _this.tableItems[data.index]['agencia'] = response.data.agencia;
        _this.tableItems[data.index]['numero'] = response.data.numero;
        _this.tableItems[data.index]['nome'] = response.data.nome;
        _this.tableItems[data.index]['obs'] = response.data.obs;
        _this.tableItems[data.index]['saldo_inicial'] = response.data.saldo_inicial;
        _this.totalLinhas++;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    editarLinha: function editarLinha(data) {
      this.editando = true;
      this.linha['banco'] = this.tableItems[data.index]['banco'];
      this.linha['agencia'] = this.tableItems[data.index]['agencia'];
      this.linha['numero'] = this.tableItems[data.index]['numero'];
      this.linha['nome'] = this.tableItems[data.index]['nome'];
      this.linha['obs'] = this.tableItems[data.index]['obs'];
      this.linha['saldo_inicial'] = this.tableItems[data.index]['saldo_inicial'];
      this.tableItems[data.index].isEdit = true;
    },
    editarRegistro: function editarRegistro(data) {
      var _this2 = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default().put('/contascorrente/' + data.item.id, this.linha).then(function (response) {
        _this2.tableItems[data.index]['banco'] = response.data.banco;
        _this2.tableItems[data.index]['agencia'] = response.data.agencia;
        _this2.tableItems[data.index]['numero'] = response.data.numero;
        _this2.tableItems[data.index]['nome'] = response.data.nome;
        _this2.tableItems[data.index]['obs'] = response.data.obs;
        _this2.tableItems[data.index]['saldo_inicial'] = response.data.saldo_inicial;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    salvarRegistro: function salvarRegistro(data) {
      if (this.adicionando) {
        this.addContaCorrente(data);
      } else {
        this.editarRegistro(data);
      }

      this.tableItems[data.index].isEdit = false;
      this.editando = false;
      this.adicionando = false;
      this.$emit('input', this.tableItems);
      this.limpaLinha();
    },
    cancelarAlteracoes: function cancelarAlteracoes(data) {
      if (this.adicionando) {
        this.tableItems.shift();
      }

      this.editando = false;
      this.tableItems[data.index].isEdit = false;
      this.adicionando = false;
      this.limpaLinha();
    },
    alteraTabela: function alteraTabela(value, key) {
      this.linha[key] = value;
      this.$emit("input", this.linha);
    },
    addNovaLinha: function addNovaLinha() {
      this.editando = true;
      var newRow = this.tableFields.reduce(function (a, c) {
        return _objectSpread(_objectSpread({}, a), {}, _defineProperty({}, c.key, null));
      }, {});
      newRow.isEdit = true;
      this.tableItems.unshift(newRow);
      this.adicionando = true;
    },
    removeLinha: function removeLinha(data) {
      var _this3 = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default()["delete"]('/contascorrente/' + data.item.id).then(function (response) {
        _this3.tableItems = _this3.tableItems.filter(function (item, i) {
          return i !== data.index;
        });

        _this3.$emit('input', _this3.tableItems);

        _this3.totalLinhas--;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    limpaLinha: function limpaLinha() {
      this.linha.banco = null, this.linha.agencia = null, this.linha.numero = null, this.linha.nome = null, this.linha.obs = null, this.linha.saldo_inicial = null;
    },
    onFiltered: function onFiltered(filteredItems) {
      this.totalLinhas = filteredItems.length;
    },
    get: function get() {
      var _this4 = this;

      this.isBusy = true;
      axios__WEBPACK_IMPORTED_MODULE_0___default().get('/contascorrente/get').then(function (response) {
        _this4.totalLinhas = response.data.length;
        _this4.tableItems = response.data.map(function (item) {
          return _objectSpread(_objectSpread({}, item), {}, {
            isEdit: false
          });
        });
      })["catch"](function (error) {
        console.log(error);
      });
      this.isBusy = false;
    }
  },
  mounted: function mounted() {
    this.get();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("div", {
    attrs: {
      id: "ContasCorrente"
    }
  }, [[_c("b-container", {
    attrs: {
      fluid: ""
    }
  }, [_c("b-row", [_c("b-col", {
    attrs: {
      md: "2",
      lg: "2"
    }
  }, [_c("b-button", {
    staticClass: "add-button d-flex",
    attrs: {
      variant: "success"
    },
    on: {
      click: _vm.addNovaLinha
    }
  }, [_vm._v("\n                    Adicionar\n                ")])], 1), _vm._v(" "), _c("b-col", {
    attrs: {
      md: "4",
      lg: "4"
    }
  }, [_c("b-input-group", [_c("b-form-input", {
    attrs: {
      id: "filter-input",
      type: "search",
      placeholder: "Pesquisar"
    },
    model: {
      value: _vm.filter,
      callback: function callback($$v) {
        _vm.filter = $$v;
      },
      expression: "filter"
    }
  }), _vm._v(" "), _c("b-input-group-append", [_c("b-button", {
    attrs: {
      disabled: !_vm.filter,
      variant: "outline-secondary"
    },
    on: {
      click: function click($event) {
        _vm.filter = "";
      }
    }
  }, [_c("b-icon", {
    attrs: {
      icon: "backspace"
    }
  })], 1)], 1)], 1)], 1), _vm._v(" "), _c("b-col", {
    attrs: {
      md: "6",
      lg: "6"
    }
  }, [_c("b-form-checkbox-group", {
    staticClass: "mt-1 d-flex",
    model: {
      value: _vm.filterOn,
      callback: function callback($$v) {
        _vm.filterOn = $$v;
      },
      expression: "filterOn"
    }
  }, [_c("b-form-checkbox", {
    staticClass: "m-2",
    attrs: {
      value: "banco"
    }
  }, [_vm._v("\n                        Banco\n                    ")]), _vm._v(" "), _c("b-form-checkbox", {
    staticClass: "m-2",
    attrs: {
      value: "agencia"
    }
  }, [_vm._v("\n                        Agência\n                    ")]), _vm._v(" "), _c("b-form-checkbox", {
    staticClass: "m-2",
    attrs: {
      value: "numero"
    }
  }, [_vm._v("\n                        Conta Corrente\n                    ")])], 1)], 1)], 1), _vm._v(" "), _c("b-table", {
    staticClass: "b-table",
    attrs: {
      items: _vm.tableItems,
      fields: _vm.tableFields,
      busy: _vm.isBusy,
      filter: _vm.filter,
      "filter-included-fields": _vm.filterOn,
      responsive: ""
    },
    on: {
      filtered: _vm.onFiltered
    },
    scopedSlots: _vm._u([{
      key: "cell(banco)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["banco"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "banco");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(agencia)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["agencia"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "agencia");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(numero)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["numero"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "numero");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(nome)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["nome"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "nome");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(obs)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["obs"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "obs");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(saldo_inicial)",
      fn: function fn(data) {
        return [_vm.tableItems[data.index].isEdit ? _c("b-form-input", {
          attrs: {
            type: "text",
            value: _vm.linha["saldo_inicial"]
          },
          on: {
            blur: function blur(e) {
              return _vm.alteraTabela(e.target.value, "saldo_inicial");
            }
          }
        }) : _c("span", [_vm._v(_vm._s(data.value))])];
      }
    }, {
      key: "cell(edit)",
      fn: function fn(data) {
        return [_c("div", {
          staticClass: "d-flex flex-nowrap"
        }, [!_vm.editando ? _c("b-button", {
          staticClass: "m-1",
          attrs: {
            variant: "primary"
          },
          on: {
            click: function click($event) {
              return _vm.editarLinha(data);
            }
          }
        }, [_c("b-icon", {
          attrs: {
            icon: "pencil-square"
          }
        })], 1) : _vm._e(), _vm._v(" "), _vm.editando && _vm.tableItems[data.index].isEdit ? _c("b-button", {
          staticClass: "m-1",
          attrs: {
            variant: "success"
          },
          on: {
            click: function click($event) {
              return _vm.salvarRegistro(data);
            }
          }
        }, [_c("b-icon", {
          attrs: {
            icon: "save"
          }
        })], 1) : _vm._e(), _vm._v(" "), _vm.editando && _vm.tableItems[data.index].isEdit ? _c("b-button", {
          staticClass: "m-1",
          attrs: {
            variant: "danger"
          },
          on: {
            click: function click($event) {
              return _vm.cancelarAlteracoes(data);
            }
          }
        }, [_c("b-icon", {
          attrs: {
            icon: "x-lg"
          }
        })], 1) : _vm._e(), _vm._v(" "), !_vm.editando ? _c("b-button", {
          staticClass: "delete-button m-1",
          attrs: {
            variant: "danger"
          },
          on: {
            click: function click($event) {
              return _vm.removeLinha(data);
            }
          }
        }, [_c("b-icon", {
          attrs: {
            icon: "trash"
          }
        })], 1) : _vm._e()], 1)];
      }
    }, {
      key: "table-caption",
      fn: function fn() {
        return [_vm._v("\n                    Total de Contas corrente: " + _vm._s(_vm.totalLinhas) + " \n                ")];
      },
      proxy: true
    }, {
      key: "table-busy",
      fn: function fn() {
        return [_c("div", {
          staticClass: "text-center text-danger my-2"
        }, [_c("b-spinner", {
          staticClass: "align-middle"
        }), _vm._v(" "), _c("strong", [_vm._v("Carregando...")])], 1)];
      },
      proxy: true
    }])
  })], 1)]], 2);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n#ContasCorrente {\n    text-align: center;\n    margin: 10px;\n}\nthead, tbody, tfoot, tr, td, th {\n    text-align: left;\n    width: 100px;\n    vertical-align: middle;\n}\n.add-button {\n        margin-bottom: 10px;\n}\nspan.sr-only {\n        display:none;\n}\nlabel.custom-control-label {\n        padding-left: 5px;\n}\npre {\n        text-align: left;\n        color: #d63384;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_style_index_0_id_8a10b5fa_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_style_index_0_id_8a10b5fa_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_style_index_0_id_8a10b5fa_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./resources/js/components/contas_corrente/ContasCorrente.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/contas_corrente/ContasCorrente.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ContasCorrente.vue?vue&type=template&id=8a10b5fa& */ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa&");
/* harmony import */ var _ContasCorrente_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ContasCorrente.vue?vue&type=script&lang=js& */ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js&");
/* harmony import */ var _ContasCorrente_vue_vue_type_style_index_0_id_8a10b5fa_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& */ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ContasCorrente_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__.render,
  _ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/contas_corrente/ContasCorrente.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContasCorrente.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_template_id_8a10b5fa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContasCorrente.vue?vue&type=template&id=8a10b5fa& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=template&id=8a10b5fa&");


/***/ }),

/***/ "./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ContasCorrente_vue_vue_type_style_index_0_id_8a10b5fa_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/contas_corrente/ContasCorrente.vue?vue&type=style&index=0&id=8a10b5fa&lang=css&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent(
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */,
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options =
    typeof scriptExports === 'function' ? scriptExports.options : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) {
    // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
          injectStyles.call(
            this,
            (options.functional ? this.parent : this).$root.$options.shadowRoot
          )
        }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection(h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing ? [].concat(existing, hook) : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

}]);