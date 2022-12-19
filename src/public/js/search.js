/******/ (function(modules) { // webpackBootstrap
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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

document.addEventListener('DOMContentLoaded', function (event) {
    window.lang_slug = "";
    if (typeof language !== 'undefined' && language !== false && language != '') {
        window.lang_slug = language + "/";
    }

    function toggleClass(element, className) {
        element.classList.contains(className) ? element.classList.remove(className) : element.classList.add(className);
    }

    function switchClass(element, classOne, classTwo) {
        toggleClass(element, classOne);
        toggleClass(element, classTwo);
    }

    function displaySearch() {
        switchClass(document.querySelector('.search-bar'), 'opacity-0', 'opacity-100');
        switchClass(document.querySelector('.search-bar'), 'z-0', 'z-50');
        document.querySelector('.search').focus();

        document.querySelector('.search-results').innerHTML = '';
        if (document.querySelector('.search-results').classList.contains('border')) {
            document.querySelector('.search-results').classList.remove('border');
        }
    }

    function closeSearch() {
        if (!document.querySelector('.search-bar').classList.contains('opacity-100')) return;
        document.querySelector('.search').value = '';
        document.querySelector('.search-results').innerHTML = '';
        switchClass(document.querySelector('.search-bar'), 'opacity-0', 'opacity-100');
        switchClass(document.querySelector('.search-bar'), 'z-0', 'z-50');
        document.querySelector('.search').blur();
    }

    function displaySearchNarrow() {
        document.querySelector('.search-bar').classList.add('display-search-acitve');
        document.querySelector('.search').focus();
        document.querySelector('.close-search-narrow').classList.remove('hidden');
        document.querySelector('.display-search-narrow').classList.add('hidden');
        document.getElementById('menu-space').classList.add('hidden');
        document.getElementById('logo-space').classList.add('hidden');
    }

    function closeSearchNarrow() {
        document.querySelector('.search-bar').classList.remove('display-search-acitve');
        document.querySelector('.close-search-narrow').classList.add('hidden');
        document.querySelector('.display-search-narrow').classList.remove('hidden');
        document.querySelector('.search-results').classList.remove('border');
        document.getElementById('menu-space').classList.remove('hidden');
        document.getElementById('logo-space').classList.remove('hidden');
        document.querySelector('.search').value = '';
        document.querySelector('.search-results').innerHTML = '';
        // switchClass(
        //     document.querySelector('.search-bar'),
        //     'opacity-0',
        //     'opacity-100'
        // )
        searchInput.blur();
    }

    // document.querySelector('.display-search').addEventListener('click', event => {
    //     document.querySelector('.search-results').innerHTML = '';
    //     if(document.querySelector('.search-results').classList.contains('border')) {
    //         document.querySelector('.search-results').classList.remove('border');
    //     }
    //     return;
    // });


    var triggerSearch = function triggerSearch(event) {
        if (!event.target.value) {
            document.querySelector('.search-results').innerHTML = '';
            if (document.querySelector('.search-results').classList.contains('border')) {
                document.querySelector('.search-results').classList.remove('border');
            }
            return;
        } else if (event.target.value.length < 3) {
            return;
        }
        // fetch('/search/' + event.target.value, {
        fetch('/' + lang_slug + 'laravel-search' + '/' + event.target.value + '/', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest"
            },
            method: 'GET',
            credentials: "same-origin"
        }).then(function (response) {
            return response.json();
        }).then(function (returned) {
            var data = returned.resultSet;
            var results = document.querySelector('.search-results');
            results.innerHTML = '';

            var _iteratorNormalCompletion = true;
            var _didIteratorError = false;
            var _iteratorError = undefined;

            try {
                for (var _iterator = Object.entries(data)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                    var _titleDiv;

                    var _ref = _step.value;

                    var _ref2 = _slicedToArray(_ref, 2);

                    var title = _ref2[0];
                    var searchData = _ref2[1];

                    if (!document.querySelector('.search-results').classList.contains('border')) {
                        document.querySelector('.search-results').classList.add('border');
                    }
                    var nodes = searchData['results'];
                    var titleDiv = document.querySelector('.' + title.replaceAll(/[^A-Z0-9]+/ig, '-') + '-search');
                    if (!titleDiv) {
                        titleDiv = document.createElement('div');
                        titleDiv.classList.add(title.replace(/[^A-Z0-9]+/ig, '-') + '-search');
                    }
                    if (!nodes.length > 0) {
                        if (titleDiv.parentNode) titleDiv.parentNode.removeChild(titleDiv);
                        continue;
                    }

                    var searchResults = nodes.map(function (node) {
                        var childLink = document.createElement('a');
                        childLink.classList.add('child-link');
                        childLink.href = node.href;
                        var childDiv = document.createElement('div');
                        childDiv.textContent = node.title.replace('<br>', '');
                        childLink.append(childDiv);
                        return childLink;
                    });

                    titleDiv.innerHTML = '';
                    //Search item title
                    if (nodes.length > 0) {
                        //Format title text
                        itemTitle = document.createElement('div');
                        itemTitle.classList.add('search-item-title', 'justify-between');

                        titleTextElement = document.createElement('span');
                        titleTextElement.innerHTML = nodes.length > 0 ? title + ' (' + searchData['count'] + ')' : '';
                        viewAllElement = document.createElement('a');

                        viewAllElement.classList.add('cursor-pointer');
                        viewAllElement.setAttribute('href', '/' + lang_slug + 'view-all/' + searchData['type'] + '/?q=' + returned.searchFor);
                        viewAllElement.innerHTML = 'View All';

                        itemTitle.append(titleTextElement);
                        itemTitle.append(viewAllElement);
                        titleDiv.append(itemTitle);
                    }
                    //Search items (results)
                    (_titleDiv = titleDiv).append.apply(_titleDiv, _toConsumableArray(searchResults));

                    results.append(titleDiv);
                }
            } catch (err) {
                _didIteratorError = true;
                _iteratorError = err;
            } finally {
                try {
                    if (!_iteratorNormalCompletion && _iterator.return) {
                        _iterator.return();
                    }
                } finally {
                    if (_didIteratorError) {
                        throw _iteratorError;
                    }
                }
            }

            if (!document.querySelector('.search-results').hasChildNodes()) {
                document.querySelector('.search-results').classList.remove('border');
            }

            //Search all on Enter click
            document.querySelector('.search').addEventListener('keydown', function (event) {
                if (event.key == 'Enter' && event.currentTarget.value.length > 2) {
                    window.location.href = '/' + lang_slug + 'view-all/' + '?q=' + returned.searchFor;
                }
            });
        }).catch(function (error) {
            return console.error(error);
        });
    };

    document.querySelector('.search').addEventListener('input', triggerSearch);
    if (document.body.contains(document.querySelector('.display-search-narrow'))) {
        document.querySelector('.display-search-narrow').addEventListener('click', function () {
            return displaySearchNarrow();
        });
        document.querySelector('.close-search-narrow').addEventListener('click', function () {
            return closeSearchNarrow();
        });
    } else {
        document.querySelector('.display-search').addEventListener('click', function () {
            return displaySearch();
        });
        document.querySelector('.close-search').addEventListener('click', function () {
            return closeSearch();
        });
    }

    document.querySelector('.search').addEventListener('keydown', function (event) {
        if (event.key == 'Escape') closeSearch();
        if (event.key !== 'ArrowDown') return;
        event.preventDefault();
        document.querySelector('.search-results').querySelectorAll('.child-link').forEach(function (item, index, items) {
            items[0].focus();
            item.addEventListener('keydown', function (e) {
                e.preventDefault();
                if (e.key == 'ArrowDown') {
                    if (items.length - 1 === index) {
                        return;
                    }
                    items[index + 1].focus();
                } else if (e.key == 'ArrowUp') {
                    if (index === 0) {
                        document.querySelector('.search').focus();
                        return;
                    }
                    items[index - 1].focus();
                } else if (e.key == 'Enter') {
                    if (!item.href) return;
                    window.location.href = item.href;
                } else if (e.key == 'Escape') {
                    closeSearch();
                }
            });
        });
    });

    document.querySelector('body').addEventListener('click', function () {
        if (document.querySelector('.search-bar').contains(document.activeElement)) return;
        closeSearch();
    });
});

/***/ })
/******/ ]);