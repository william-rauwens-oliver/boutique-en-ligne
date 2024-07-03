document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.placeholder = 'Recherché des produits...';
            searchInput.id = 'product-search';
            document.querySelector('nav').appendChild(searchInput);

            searchInput.addEventListener('input', async () => {
                const query = searchInput.value;
                if (query.length > 2) {
                    const response = await fetch(`/search?query=${query}`);
                    const results = await response.json();
                    displayAutocompleteResults(results);
                }
            });

            function displayAutocompleteResults(results) {
                const resultBox = document.createElement('div');
                resultBox.className = 'autocomplete-results';
                resultBox.innerHTML = results.map(result => `<p>${result.name}</p>`).join('');
                document.querySelector('nav').appendChild(resultBox);
            }
        });