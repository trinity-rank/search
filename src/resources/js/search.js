document.addEventListener('DOMContentLoaded', (event) => {
    window.lang_slug = "";
    if (typeof language !== 'undefined' && language !== false && language != '' ) {
        window.lang_slug = language + "/";
    }

    function toggleClass( element, className ) {
        element.classList.contains(className) ? element.classList.remove(className) : element.classList.add(className)
    }

    function switchClass( element, classOne, classTwo ) {
        toggleClass(element, classOne);
        toggleClass(element, classTwo);
    }

    function displaySearch() {
        switchClass(document.querySelector('.search-bar'), 'opacity-0', 'opacity-100');
        switchClass(document.querySelector('.search-bar'), 'z-0', 'z-50');
        document.querySelector('.search').focus();

        document.querySelector('.search-results').innerHTML = '';
        if(document.querySelector('.search-results').classList.contains('border')) {
            document.querySelector('.search-results').classList.remove('border');
        }
    }

    function closeSearch() {
        if(!document.querySelector('.search-bar').classList.contains('opacity-100')) return;
        document.querySelector('.search').value = '';
        document.querySelector('.search-results').innerHTML = '';
        switchClass(document.querySelector('.search-bar'), 'opacity-0', 'opacity-100');
        switchClass(document.querySelector('.search-bar'), 'z-0', 'z-50');
        document.querySelector('.search').blur();
    }



    function displaySearchNarrow() {
        document.querySelector('.search-bar').classList.add('display-search-acitve')
        document.querySelector('.search').focus()
        document.querySelector('.close-search-narrow').classList.remove('hidden')
        document.querySelector('.display-search-narrow').classList.add('hidden')
        document.getElementById('menu-space').classList.add('hidden')
        document.getElementById('logo-space').classList.add('hidden')
    }

    function closeSearchNarrow() {
        document.querySelector('.search-bar').classList.remove('display-search-acitve')
        document.querySelector('.close-search-narrow').classList.add('hidden')
        document.querySelector('.display-search-narrow').classList.remove('hidden')
        document.querySelector('.search-results').classList.remove('border')
        document.getElementById('menu-space').classList.remove('hidden')
        document.getElementById('logo-space').classList.remove('hidden')
        document.querySelector('.search').value = ''
        document.querySelector('.search-results').innerHTML = ''
        // switchClass(
        //     document.querySelector('.search-bar'),
        //     'opacity-0',
        //     'opacity-100'
        // )
        searchInput.blur()
    }



    // document.querySelector('.display-search').addEventListener('click', event => {
    //     document.querySelector('.search-results').innerHTML = '';
    //     if(document.querySelector('.search-results').classList.contains('border')) {
    //         document.querySelector('.search-results').classList.remove('border');
    //     }
    //     return;
    // });


    var triggerSearch = function(event) {
        if(!event.target.value) {
            document.querySelector('.search-results').innerHTML = '';
            if(document.querySelector('.search-results').classList.contains('border')) {
                document.querySelector('.search-results').classList.remove('border');
            }
            return;
        } else if(event.target.value.length < 3) {
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
        })
        .then(response => {
            return response.json();
        })
        .then(returned => {
            var data = returned.resultSet;
            let results = document.querySelector('.search-results');
            results.innerHTML = '';
            
            for (let [title, searchData] of Object.entries(data)) {
                if(!document.querySelector('.search-results').classList.contains('border')) {
                    document.querySelector('.search-results').classList.add('border');
                }
                let nodes = searchData['results'];
                var titleDiv = document.querySelector('.' + title.replaceAll(/[^A-Z0-9]+/ig, '-') + '-search');
                if(!titleDiv) {
                    titleDiv = document.createElement('div');
                    titleDiv.classList.add(title.replace(/[^A-Z0-9]+/ig, '-') + '-search');
                }
                if(!nodes.length > 0) {
                    if(titleDiv.parentNode) titleDiv.parentNode.removeChild(titleDiv);
                    continue;
                }

                let searchResults = nodes.map(node => {
                    let childLink = document.createElement('a');
                    childLink.classList.add('child-link');
                    childLink.href = node.href;
                    let childDiv = document.createElement('div');
                    childDiv.textContent = node.title.replace('<br>', '');
                    childLink.append(childDiv);
                    return childLink;
                });

                titleDiv.innerHTML = '';
                //Search item title
                if(nodes.length > 0) {
                    //Format title text
                    itemTitle = document.createElement('div');
                    itemTitle.classList.add('search-item-title', 'justify-between');

                    titleTextElement = document.createElement('span');
                    titleTextElement.innerHTML = nodes.length > 0 ? title + ' (' +searchData['count'] + ')' : '';
                    viewAllElement = document.createElement('a');

                    viewAllElement.classList.add('cursor-pointer');
                    viewAllElement.setAttribute('href', '/' + lang_slug + 'view-all/'+ searchData['type'] +'/?q='+ returned.searchFor);
                    viewAllElement.innerHTML = 'View All';

                    itemTitle.append(titleTextElement);
                    itemTitle.append(viewAllElement);
                    titleDiv.append(itemTitle);
                }
                //Search items (results)
                titleDiv.append(...searchResults);

                results.append(titleDiv);
            }
            if(!document.querySelector('.search-results').hasChildNodes()) {
                document.querySelector('.search-results').classList.remove('border');
            }

            //Search all on Enter click
            document.querySelector('.search')
                .addEventListener('keydown', event => {
                    if(event.key == 'Enter' && event.currentTarget.value.length > 2) {
                        window.location.href = '/' + lang_slug + 'view-all/' + '?q=' + returned.searchFor;
                    }
                });
        })
        .catch(error => console.error(error));
    };

    document.querySelector('.search').addEventListener('input', triggerSearch);
    if( document.body.contains( document.querySelector('.display-search-narrow') ) ) {
        document.querySelector('.display-search-narrow').addEventListener('click', () => displaySearchNarrow());
        document.querySelector('.close-search-narrow').addEventListener('click', () => closeSearchNarrow());
    }
    else {
        document.querySelector('.display-search').addEventListener('click', () => displaySearch());
        document.querySelector('.close-search').addEventListener('click', () => closeSearch());
    }

    document.querySelector('.search')
        .addEventListener('keydown', event => {
            if(event.key == 'Escape') closeSearch();
            if(event.key !== 'ArrowDown') return;
            event.preventDefault();
            document.querySelector('.search-results').querySelectorAll('.child-link').forEach((item, index, items) => {
                items[0].focus();
                item.addEventListener('keydown', e => {
                    e.preventDefault();
                    if(e.key == 'ArrowDown') {
                        if(items.length - 1 === index) {
                            return;
                        }
                        items[index + 1].focus();
                    } else if(e.key == 'ArrowUp') {
                        if(index === 0) {
                            document.querySelector('.search').focus();
                            return;
                        }
                        items[index - 1].focus();
                    } else if(e.key == 'Enter') {
                        if(!item.href) return;
                        window.location.href = item.href;
                    } else if(e.key == 'Escape') {
                        closeSearch();
                    }
                });
            });
        });

    document.querySelector('body')
        .addEventListener('click', () => {
            if(document.querySelector('.search-bar').contains(document.activeElement)) return;
            closeSearch();
        });
})

