document.addEventListener('DOMContentLoaded', function() {
    // Product image gallery
    const mainImage = document.querySelector('.product-main-image');
    const thumbnails = document.querySelectorAll('.product-thumbnail');
    
    if (mainImage && thumbnails.length) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => {
                mainImage.src = thumb.dataset.full;
                thumbnails.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
            });
        });
    }

    // Quantity controls
    const quantityControls = document.querySelectorAll('.quantity-control');
    quantityControls.forEach(control => {
        const input = control.querySelector('input');
        const increment = control.querySelector('.increment');
        const decrement = control.querySelector('.decrement');

        increment?.addEventListener('click', () => {
            input.value = Math.min(parseInt(input.value) + 1, parseInt(input.max) || 99);
            input.dispatchEvent(new Event('change'));
        });

        decrement?.addEventListener('click', () => {
            input.value = Math.max(parseInt(input.value) - 1, parseInt(input.min) || 1);
            input.dispatchEvent(new Event('change'));
        });
    });

    // Review form validation
    const reviewForm = document.querySelector('#review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', (e) => {
            const rating = reviewForm.querySelector('input[name="rating"]:checked');
            const comment = reviewForm.querySelector('textarea[name="comment"]');

            if (!rating) {
                e.preventDefault();
                alert('Please select a rating');
            }

            if (comment.value.length < 10) {
                e.preventDefault();
                alert('Review comment must be at least 10 characters long');
            }
        });
    }
});