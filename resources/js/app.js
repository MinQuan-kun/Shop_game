import './bootstrap';

import Alpine from 'alpinejs';

import Swal from 'sweetalert2';

window.Swal = Swal;

window.Alpine = Alpine;


window.confirmDelete = function(formId) {
    Swal.fire({
        title: 'Bạn có chắc chắn không?',
        text: "Hành động này không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa ngay!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + formId).submit();
        }
    });
};

window.confirmResetPassword = function(userId) {
    Swal.fire({
        title: 'Xác nhận reset mật khẩu?',
        text: "Mật khẩu sẽ được đặt về '12345678'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý reset!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('reset-password-form-' + userId).submit();
        }
    });
};

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
