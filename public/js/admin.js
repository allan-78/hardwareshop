// Admin Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    if (document.querySelector('.data-table')) {
        new DataTable('.data-table', {
            responsive: true,
            pageLength: 10,
            ordering: true
        });
    }

    // Handle Image Preview
    const imageInput = document.querySelector('.image-input');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const preview = document.querySelector('.image-preview');
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    }
});