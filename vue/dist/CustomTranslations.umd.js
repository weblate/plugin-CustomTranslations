(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else if(typeof define === 'function' && define.amd)
		define(["CoreHome", , "CorePluginsAdmin"], factory);
	else if(typeof exports === 'object')
		exports["CustomTranslations"] = factory(require("CoreHome"), require("vue"), require("CorePluginsAdmin"));
	else
		root["CustomTranslations"] = factory(root["CoreHome"], root["Vue"], root["CorePluginsAdmin"]);
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE__19dc__, __WEBPACK_EXTERNAL_MODULE__8bbf__, __WEBPACK_EXTERNAL_MODULE_a5a2__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "plugins/CustomTranslations/vue/dist/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "fae3");
/******/ })
/************************************************************************/
/******/ ({

/***/ "19dc":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE__19dc__;

/***/ }),

/***/ "75eb":
/***/ (function(module, exports) {



/***/ }),

/***/ "8bbf":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE__8bbf__;

/***/ }),

/***/ "a5a2":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_a5a2__;

/***/ }),

/***/ "fae3":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// ESM COMPAT FLAG
__webpack_require__.r(__webpack_exports__);

// EXPORTS
__webpack_require__.d(__webpack_exports__, "EditCustomTranslations", function() { return /* reexport */ EditCustomTranslations; });

// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/setPublicPath.js
// This file is imported into lib/wc client bundles.

if (typeof window !== 'undefined') {
  var currentScript = window.document.currentScript
  if (false) { var getCurrentScript; }

  var src = currentScript && currentScript.src.match(/(.+\/)[^/]+\.js(\?.*)?$/)
  if (src) {
    __webpack_require__.p = src[1] // eslint-disable-line
  }
}

// Indicate to webpack that this file can be concatenated
/* harmony default export */ var setPublicPath = (null);

// EXTERNAL MODULE: external "CoreHome"
var external_CoreHome_ = __webpack_require__("19dc");

// EXTERNAL MODULE: external {"commonjs":"vue","commonjs2":"vue","root":"Vue"}
var external_commonjs_vue_commonjs2_vue_root_Vue_ = __webpack_require__("8bbf");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-babel/node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/@vue/cli-plugin-babel/node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue?vue&type=template&id=1e4de530

var _hoisted_1 = {
  class: "editCustomTranslations"
};
var _hoisted_2 = {
  class: "languageCode"
};
var _hoisted_3 = ["href"];
var _hoisted_4 = ["name"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Field = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("Field");

  var _component_ActivityIndicator = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ActivityIndicator");

  var _component_SaveButton = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("SaveButton");

  var _component_ContentBlock = Object(external_commonjs_vue_commonjs2_vue_root_Vue_["resolveComponent"])("ContentBlock");

  return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", _hoisted_1, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ContentBlock, {
    "content-title": _ctx.translate('CustomTranslations_CustomTranslations')
  }, {
    default: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withCtx"])(function () {
      return [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", _hoisted_2, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
        uicontrol: "select",
        name: "language",
        "model-value": _ctx.languageCode,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          _ctx.languageCode = $event;

          _ctx.loadLanguage();
        }),
        title: _ctx.translate('General_Language'),
        options: _ctx.languageOptions,
        "inline-help": _ctx.translate('CustomTranslations_LanguageInlineHelp')
      }, null, 8, ["model-value", "title", "options", "inline-help"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("p", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createTextVNode"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(_ctx.translate('General_GoTo2')) + " ", 1), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.translationTypes, function (translationType, index) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("span", {
          key: translationType.id
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          href: "#idType".concat(translationType.id)
        }, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(translationType.name), 9, _hoisted_3), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["withDirectives"])(Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("span", null, " | ", 512), [[external_commonjs_vue_commonjs2_vue_root_Vue_["vShow"], index !== _ctx.translationTypes.length - 1]])]);
      }), 128))]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ActivityIndicator, {
        loading: _ctx.isLoading
      }, null, 8, ["loading"]), (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(true), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])(external_commonjs_vue_commonjs2_vue_root_Vue_["Fragment"], null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["renderList"])(_ctx.translationTypes, function (translationType) {
        return Object(external_commonjs_vue_commonjs2_vue_root_Vue_["openBlock"])(), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementBlock"])("div", {
          class: Object(external_commonjs_vue_commonjs2_vue_root_Vue_["normalizeClass"])("translationType translationType".concat(translationType.id)),
          key: translationType.id
        }, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("a", {
          name: "idType".concat(translationType.id)
        }, null, 8, _hoisted_4), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("h3", null, Object(external_commonjs_vue_commonjs2_vue_root_Vue_["toDisplayString"])(translationType.name), 1), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_ActivityIndicator, {
          loading: _ctx.isLoadingTranslation[translationType.id]
        }, null, 8, ["loading"]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createElementVNode"])("div", null, [Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_Field, {
          uicontrol: "multituple",
          name: "multitupletext",
          title: translationType.description,
          modelValue: _ctx.translations[translationType.id],
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            return _ctx.translations[translationType.id] = $event;
          },
          "full-width": true,
          "ui-control-attributes": _ctx.uiControlAttributes
        }, null, 8, ["title", "modelValue", "onUpdate:modelValue", "ui-control-attributes"])]), Object(external_commonjs_vue_commonjs2_vue_root_Vue_["createVNode"])(_component_SaveButton, {
          onConfirm: function onConfirm($event) {
            return _ctx.update(translationType.id);
          },
          saving: _ctx.isUpdating[translationType.id],
          disabled: _ctx.isUpdating[translationType.id]
        }, null, 8, ["onConfirm", "saving", "disabled"])], 2);
      }), 128))];
    }),
    _: 1
  }, 8, ["content-title"])]);
}
// CONCATENATED MODULE: ./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue?vue&type=template&id=1e4de530

// EXTERNAL MODULE: external "CorePluginsAdmin"
var external_CorePluginsAdmin_ = __webpack_require__("a5a2");

// CONCATENATED MODULE: ./node_modules/@vue/cli-plugin-typescript/node_modules/cache-loader/dist/cjs.js??ref--14-0!./node_modules/babel-loader/lib!./node_modules/@vue/cli-plugin-typescript/node_modules/ts-loader??ref--14-2!./node_modules/@vue/cli-service/node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/@vue/cli-service/node_modules/vue-loader-v16/dist??ref--0-1!./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue?vue&type=script&lang=ts
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }





function hasTranslationValue(value) {
  return value !== '' && value !== false && value !== null;
}

/* harmony default export */ var EditCustomTranslationsvue_type_script_lang_ts = (Object(external_commonjs_vue_commonjs2_vue_root_Vue_["defineComponent"])({
  props: {},
  components: {
    ContentBlock: external_CoreHome_["ContentBlock"],
    Field: external_CorePluginsAdmin_["Field"],
    ActivityIndicator: external_CoreHome_["ActivityIndicator"],
    SaveButton: external_CorePluginsAdmin_["SaveButton"]
  },
  data: function data() {
    return {
      languageCode: 'en',
      translationTypes: [],
      languageOptions: [],
      isUpdating: {},
      translations: {},
      isLoadingTranslation: {},
      isLoading: false
    };
  },
  setup: function setup() {
    var translationTypesPromise = external_CoreHome_["AjaxHelper"].fetch({
      method: 'CustomTranslations.getTranslatableTypes'
    });
    return {
      translationTypesPromise: translationTypesPromise
    };
  },
  created: function created() {
    var _this = this;

    external_CoreHome_["AjaxHelper"].fetch({
      method: 'LanguagesManager.getAvailableLanguagesInfo'
    }).then(function (languages) {
      _this.languageOptions = [];
      languages.forEach(function (language) {
        var title = language.english_name;

        if (language.english_name !== language.name) {
          title += " (".concat(language.name, ")");
        }

        if (external_CoreHome_["Matomo"].languageName === language.english_name || external_CoreHome_["Matomo"].languageName === language.name) {
          _this.languageCode = language.code;
        }

        _this.languageOptions.push({
          key: language.code,
          value: title
        });
      });
    });
    this.loadLanguage();
  },
  methods: {
    loadLanguage: function loadLanguage() {
      var _this2 = this;

      this.isLoadingTranslation = {};
      this.translations = {};
      this.isLoading = true;
      this.translationTypesPromise.then(function (translationTypes) {
        _this2.translations = {};
        _this2.translationTypes = translationTypes;
        translationTypes.forEach(function (translationType) {
          var idType = translationType.id;
          _this2.isLoading = false;
          _this2.isLoadingTranslation[idType] = true;
          external_CoreHome_["AjaxHelper"].fetch({
            method: 'CustomTranslations.getTranslationsForType',
            idType: idType,
            languageCode: _this2.languageCode
          }).then(function (translations) {
            _this2.translations[idType] = [];

            if (translations) {
              Object.entries(translations).forEach(function (_ref) {
                var _ref2 = _slicedToArray(_ref, 2),
                    key = _ref2[0],
                    translation = _ref2[1];

                if (hasTranslationValue(translation)) {
                  _this2.translations[idType].push({
                    key: key,
                    value: translation
                  });
                }
              });
            }

            translationType.translationKeys.forEach(function (translationKey) {
              if (!translations[translationKey]) {
                _this2.translations[idType].push({
                  key: translationKey,
                  value: ''
                });
              }
            });
            _this2.isLoadingTranslation[idType] = false;
          });
        });
      });
    },
    update: function update(idType) {
      var _this3 = this;

      this.isUpdating[idType] = true;
      var translations = {};
      this.translations[idType].forEach(function (translation) {
        if (translation.key && hasTranslationValue(translation.value)) {
          translations[translation.key] = translation.value;
        }
      });
      external_CoreHome_["AjaxHelper"].post({
        method: 'CustomTranslations.setTranslations',
        idType: idType,
        languageCode: this.languageCode
      }, {
        translations: translations
      }).finally(function () {
        _this3.isUpdating[idType] = false;
      });
    }
  },
  computed: {
    uiControlAttributes: function uiControlAttributes() {
      return {
        field1: {
          key: 'key',
          title: Object(external_CoreHome_["translate"])('General_Value'),
          uiControl: 'text',
          availableValues: null
        },
        field2: {
          key: 'value',
          title: Object(external_CoreHome_["translate"])('CustomTranslations_Translation'),
          uiControl: 'text',
          availableValues: null
        }
      };
    }
  }
}));
// CONCATENATED MODULE: ./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue?vue&type=script&lang=ts
 
// EXTERNAL MODULE: ./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue?vue&type=custom&index=0&blockType=todo
var EditCustomTranslationsvue_type_custom_index_0_blockType_todo = __webpack_require__("75eb");
var EditCustomTranslationsvue_type_custom_index_0_blockType_todo_default = /*#__PURE__*/__webpack_require__.n(EditCustomTranslationsvue_type_custom_index_0_blockType_todo);

// CONCATENATED MODULE: ./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.vue



EditCustomTranslationsvue_type_script_lang_ts.render = render
/* custom blocks */

if (typeof EditCustomTranslationsvue_type_custom_index_0_blockType_todo_default.a === 'function') EditCustomTranslationsvue_type_custom_index_0_blockType_todo_default()(EditCustomTranslationsvue_type_script_lang_ts)


/* harmony default export */ var EditCustomTranslations = (EditCustomTranslationsvue_type_script_lang_ts);
// CONCATENATED MODULE: ./plugins/CustomTranslations/vue/src/EditCustomTranslations/EditCustomTranslations.adapter.ts
/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */


/* harmony default export */ var EditCustomTranslations_adapter = (Object(external_CoreHome_["createAngularJsAdapter"])({
  component: EditCustomTranslations,
  directiveName: 'matomoEditCustomTranslations'
}));
// CONCATENATED MODULE: ./plugins/CustomTranslations/vue/src/index.ts
/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */


// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib-no-default.js




/***/ })

/******/ });
});
//# sourceMappingURL=CustomTranslations.umd.js.map