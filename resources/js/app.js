import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Autocomplete function
window.searchAutocomplete = function() {
    return {
        open: false,
        suggestions: [],
        timeout: null,
        search(query) {
            clearTimeout(this.timeout);
            
            if (!query || query.length < 2) {
                this.suggestions = [];
                this.open = false;
                return;
            }
            
            this.timeout = setTimeout(() => {
                fetch(`/api/games/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        this.suggestions = data;
                        this.open = data.length > 0;
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        this.suggestions = [];
                        this.open = false;
                    });
            }, 300);
        },
        closeSuggestions() {
            this.open = false;
        }
    };
};

Alpine.start();
