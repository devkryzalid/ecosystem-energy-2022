/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/scripts/main.js":
/*!********************************!*\
  !*** ./assets/scripts/main.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _utils_jsBlockLink__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils/jsBlockLink */ \"./assets/scripts/utils/jsBlockLink.js\");\n/* harmony import */ var _utils_jsBlockLink__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_utils_jsBlockLink__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _utils_menu__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/menu */ \"./assets/scripts/utils/menu.js\");\n/*\n  Main Js file, called on every page of the site \n*/\n\n\n\nconst menu = new _utils_menu__WEBPACK_IMPORTED_MODULE_1__[\"default\"]();\n\n//# sourceURL=webpack://ecosystem/./assets/scripts/main.js?");

/***/ }),

/***/ "./assets/scripts/utils/jsBlockLink.js":
/*!*********************************************!*\
  !*** ./assets/scripts/utils/jsBlockLink.js ***!
  \*********************************************/
/***/ (function() {

eval("/*\n  Add JsBlockLink method \n  Search a href=\"\" in a block\n  Better for SEO\n*/\ndocument.querySelectorAll(\".jsBlockLink\").forEach(element => {\n  element.addEventListener('click', event => {\n    const link = event.currentTarget.querySelectorAll('a:not(.jsIgnoreBlockLink)')[0];\n\n    if (!link.classList.contains('jsIgnoreBlockLink')) {\n      if ((link.getAttribute('target') && link.getAttribute('target') === '_blank') ||\n        event.ctrlKey ||\n        event.button === 1) {\n        window.open(link.getAttribute('href'));\n      }\n      else if (event.button === 0) {\n        document.location.href = link.getAttribute('href');\n      }\n    }\n    return false;\n  })\n})\n\n//# sourceURL=webpack://ecosystem/./assets/scripts/utils/jsBlockLink.js?");

/***/ }),

/***/ "./assets/scripts/utils/menu.js":
/*!**************************************!*\
  !*** ./assets/scripts/utils/menu.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ Menu; }\n/* harmony export */ });\nclass Menu {\n  // DOM elements\n  body = document.body;\n  container = document.getElementById('menu');\n  button = document.getElementById('menu-toggle');\n  \n  active = false;\n\n  constructor () {\n    // Add click listener to burger/close menu button\n    this.button.addEventListener('click', () => this.toggle());\n\n    // Add click listener to all secondary menu triggers\n    document.querySelectorAll('.secondary-link').forEach(link => {\n      link.addEventListener('click', this.openSecondaryMenu)\n    })\n  }\n\n  // Menu display toggler\n  toggle = (forcedValue = null) => {\n    this.closeAllSecondaryMenus();\n\n    // Set forced value if available, otherwise set to opposite of current value\n    this.active = forcedValue === null\n      ? !this.active\n      : !!forcedValue;\n\n    if (this.active) this.openMainMenu();\n    else this.closeMainMenu();\n  }\n\n  // Primary menu controls\n  openMainMenu = () => {\n    this.container.classList.add('show');\n    this.body.classList.add('menu-open');\n  }\n\n  closeMainMenu = () => {\n    this.container.classList.remove('show');\n    this.body.classList.remove('menu-open');\n  }\n\n  // Secondary menu controls\n  openSecondaryMenu = event => {\n    this.closeAllSecondaryMenus();\n    const menu = event.target.parentNode.querySelector('.secondary-menu');\n    menu.classList.add('show')\n  }\n\n  closeAllSecondaryMenus = () => {\n    document.querySelectorAll('.secondary-menu').forEach(menu => {\n      menu.classList.remove('show');\n    })\n  }\n}\n\n//# sourceURL=webpack://ecosystem/./assets/scripts/utils/menu.js?");

/***/ }),

/***/ "./assets/styles/main.scss":
/*!*********************************!*\
  !*** ./assets/styles/main.scss ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://ecosystem/./assets/styles/main.scss?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	__webpack_require__("./assets/scripts/main.js");
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/styles/main.scss");
/******/ 	
/******/ })()
;