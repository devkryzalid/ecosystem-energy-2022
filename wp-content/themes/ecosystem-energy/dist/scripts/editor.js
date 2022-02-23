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

/***/ "./assets/scripts/editor.js":
/*!**********************************!*\
  !*** ./assets/scripts/editor.js ***!
  \**********************************/
/***/ (function() {

eval("wp.domReady(() => {\n  /*\n    Change Gutenbergs Buttons block\n    Unregister Default Block\n    Create new Block \n  */\n  wp.blocks.unregisterBlockStyle('core/button', 'outline');\n  wp.blocks.registerBlockStyle('core/button', [\n    {\n      name: 'large',\n      label: 'Large',\n      isDefault: false,\n    },\n    {\n      name: 'small',\n      label: 'Petit',\n      isDefault: false,\n    },\n    {\n      name: 'secondary',\n      label: 'Secondaire',\n      isDefault: false,\n    },\n  ]);\n\n  /*\n    Change Gutenbergs Separtor block\n    Unregister Default Block\n  */\n  wp.blocks.unregisterBlockStyle('core/separator', 'dots');\n  wp.blocks.unregisterBlockStyle('core/separator', 'wide');\n\n  /*\n    Change Gutenbergs BlockQuot block\n    Register New Style\n  */\n  wp.blocks.registerBlockStyle('core/quote', [\n    {\n      name: 'large',\n      label: 'Large',\n      isDefault: true,\n    },\n    {\n      name: 'classic',\n      label: 'Classique',\n      isDefault: false,\n    }\n  ]);\n\n  /*\n    Change Gutenbergs Paragraph block\n    Register New Style\n  */\n  wp.blocks.registerBlockStyle('core/paragraph', [\n    {\n      name: 'framed',\n      label: 'Encadrée',\n      isDefault: false,\n    }\n  ]);\n\n  /*\n    Change Gutenbergs Paragraph block\n    Register New Style\n  */\n  wp.blocks.registerBlockStyle('core/columns', [\n    {\n      name: 'framed',\n      label: 'Encadrée',\n      isDefault: false,\n    }\n  ]);\n\n  /*\n    Change Gutenbergs List block\n    Register New Style\n  */\n  wp.blocks.registerBlockStyle('core/list', [\n    {\n      name: 'bigger',\n      label: 'Mise en avant',\n      isDefault: false,\n    }\n  ]);\n\n  /*\n    Change Gutenbergs Table block\n    Unregister Default Block\n  */\n  wp.blocks.unregisterBlockStyle('core/table', 'stripes');\n\n});\n\n//# sourceURL=webpack://ecosystem/./assets/scripts/editor.js?");

/***/ }),

/***/ "./assets/styles/editor.scss":
/*!***********************************!*\
  !*** ./assets/styles/editor.scss ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://ecosystem/./assets/styles/editor.scss?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
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
/******/ 	__webpack_modules__["./assets/scripts/editor.js"](0, {}, __webpack_require__);
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/styles/editor.scss"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;