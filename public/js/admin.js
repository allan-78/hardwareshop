// Initialize DataTables
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all DataTables on the page
    if ($.fn.DataTable) {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search..."
            }
        });
    }

    // Sidebar Toggle - moved outside the nested event listener
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('mainContent');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Check window size on load and resize
    function checkWindowSize() {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
    }

    window.addEventListener('resize', checkWindowSize);
    checkWindowSize();

    // Initialize dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        if (bootstrap && bootstrap.Dropdown) {
            new bootstrap.Dropdown(dropdown);
        }
    });

    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        if (bootstrap && bootstrap.Tooltip) {
            new bootstrap.Tooltip(tooltip);
        }
    });

    // Chart Initialization - Fixed to properly check for Chart.js
    if (typeof Chart !== 'undefined') {
        // Initialize sales chart if element exists
        const salesChartEl = document.getElementById('salesChart');
        if (salesChartEl) {
            const salesCtx = salesChartEl.getContext('2d');
            if (window.salesChartData) {
                initializeSalesChart(salesCtx, window.salesChartData);
            }
        }
        
        // Initialize product sales chart if element exists
        const productChartEl = document.getElementById('productSalesChart');
        if (productChartEl) {
            const productCtx = productChartEl.getContext('2d');
            if (window.productChartData) {
                initializeProductChart(productCtx, window.productChartData);
            }
        }
    }

    // Alert Auto-dismiss
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }, 5000);
    });

    // File Input Preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const preview = this.nextElementSibling?.querySelector('img');
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Delete Confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });

    // Status Toggle
    const statusToggles = document.querySelectorAll('.status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const url = this.dataset.url;
            const status = this.checked ? 1 : 0;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Status updated successfully', 'success');
                } else {
                    showNotification('Error updating status', 'error');
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating status', 'error');
                this.checked = !this.checked;
            });
        });
    });

    // Notification System
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show fixed-top mx-auto mt-3`;
        notification.style.maxWidth = '500px';
        notification.style.zIndex = '9999';
        
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 150);
        }, 3000);
    }

    // Date Range Picker
    if ($.fn.daterangepicker) {
        $('input[name="date_range"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    }

    // Chart Initialization
    if (typeof Chart !== 'undefined' && document.getElementById('salesChart')) {
        initializeSalesChart();
    }
});

// Sales Chart Initialization
function initializeSalesChart(ctx, data) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Monthly Sales',
                data: data.values,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

// Product Sales Chart Initialization
function initializeProductChart(ctx, data) {
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.values,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b']
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            cutout: '80%'
        }
    });
}
