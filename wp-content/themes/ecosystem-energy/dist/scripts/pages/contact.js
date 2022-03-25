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

/***/ "./assets/scripts/pages/contact.js":
/*!*****************************************!*\
  !*** ./assets/scripts/pages/contact.js ***!
  \*****************************************/
/***/ (function() {

eval("document.querySelectorAll('.office-link').forEach(link => {\n  link.addEventListener('click', ({ target }) => {\n\n    // Toggle selected state\n    document.querySelectorAll('.office-link.selected').forEach(el => el.classList.remove('selected'));\n    target.classList.add('selected');\n\n    // Change office-info content\n    const infoBox = document.getElementById('office-info');\n    const content = target.nextElementSibling.innerHTML;\n    infoBox.innerHTML = content;\n\n    // Scroll to office info box\n  //  infoBox.scrollIntoView({ behavior: 'smooth', block: 'start' });\n  const y = infoBox.getBoundingClientRect().top + window.pageYOffset - 50;\n  window.scrollTo({top: y, behavior: 'smooth'});\n\n    // Select office in form\n    const option = document.querySelector(`.office-field option[value=\"${ target.text }\"]`);\n    if (option) option.selected = true;\n  })\n});\n\n//# sourceURL=webpack://ecosystem/./assets/scripts/pages/contact.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/scripts/pages/contact.js"]();
/******/ 	
/******/ })()
;