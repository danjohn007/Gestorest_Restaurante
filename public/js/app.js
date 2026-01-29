// Global JavaScript functions for the restaurant system

// Show loading spinner
function showLoading() {
    if (!document.querySelector('.spinner-overlay')) {
        const spinner = document.createElement('div');
        spinner.className = 'spinner-overlay';
        spinner.innerHTML = `
            <div class="spinner-border spinner-border-lg text-light" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        `;
        document.body.appendChild(spinner);
    }
}

// Hide loading spinner
function hideLoading() {
    const spinner = document.querySelector('.spinner-overlay');
    if (spinner) {
        spinner.remove();
    }
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN'
    }).format(amount);
}

// Confirm delete action
function confirmDelete(message = '¿Estás seguro de que deseas eliminar este elemento?') {
    return confirm(message);
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                setTimeout(function() {
                    alert.remove();
                }, 150);
            }
        }, 5000);
    });
});

// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Initialize popovers
document.addEventListener('DOMContentLoaded', function() {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// AJAX helper function
function makeRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };
    
    const config = { ...defaultOptions, ...options };
    
    return fetch(url, config)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .catch(error => {
            console.error('Request failed:', error);
            throw error;
        });
}

// Table helpers
function getStatusBadgeClass(status) {
    const statusClasses = {
        'disponible': 'bg-success',
        'ocupada': 'bg-danger',
        'cuenta_solicitada': 'bg-warning text-dark',
        'cerrada': 'bg-secondary',
        'pendiente': 'bg-secondary',
        'en_preparacion': 'bg-warning text-dark',
        'listo': 'bg-info',
        'entregado': 'bg-success'
    };
    
    return statusClasses[status] || 'bg-secondary';
}

function getStatusText(status) {
    const statusTexts = {
        'disponible': 'Disponible',
        'ocupada': 'Ocupada',
        'cuenta_solicitada': 'Cuenta Solicitada',
        'cerrada': 'Cerrada',
        'pendiente': 'Pendiente',
        'en_preparacion': 'En Preparación',
        'listo': 'Listo',
        'entregado': 'Entregado'
    };
    
    return statusTexts[status] || status;
}

// Print functionality
function printElement(elementId) {
    const element = document.getElementById(elementId);
    if (!element) {
        console.error('Element not found:', elementId);
        return;
    }
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Imprimir</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { font-size: 12px; }
                @media print {
                    .no-print { display: none !important; }
                }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            ${element.innerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
}

// Export to PDF (basic implementation using browser print)
function exportToPDF(elementId, filename = 'documento.pdf') {
    printElement(elementId);
}

// Real-time clock
function updateClock() {
    const now = new Date();
    const clockElement = document.getElementById('current-time');
    if (clockElement) {
        clockElement.textContent = now.toLocaleString('es-MX', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }
}

// Update clock every second
setInterval(updateClock, 1000);
updateClock(); // Initial call

// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle && sidebar && sidebarOverlay) {
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
        
        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
    
    // Handle dropdown toggles in sidebar
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown .dropdown-toggle');
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.closest('.sidebar-dropdown');
            const wasOpen = dropdown.classList.contains('show');
            
            // Close all other dropdowns
            document.querySelectorAll('.sidebar-dropdown.show').forEach(function(item) {
                if (item !== dropdown) {
                    item.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            if (wasOpen) {
                dropdown.classList.remove('show');
            } else {
                dropdown.classList.add('show');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.sidebar-dropdown')) {
            document.querySelectorAll('.sidebar-dropdown.show').forEach(function(dropdown) {
                dropdown.classList.remove('show');
            });
        }
    });
    
    // Highlight active menu item based on current URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link, .sidebar-nav .dropdown-item');
    
    // Sort links by href length (longest first) to match most specific paths first
    const sortedLinks = Array.from(navLinks).sort((a, b) => {
        const hrefA = a.getAttribute('href') || '';
        const hrefB = b.getAttribute('href') || '';
        return hrefB.length - hrefA.length;
    });
    
    let matchFound = false;
    sortedLinks.forEach(function(link) {
        const href = link.getAttribute('href');
        if (href && !matchFound) {
            // Exact match or path starts with href followed by / or end of string
            if (currentPath === href || (currentPath.startsWith(href + '/') && href.length > 1)) {
                link.classList.add('active');
                // Open parent dropdown if this is a dropdown item
                const dropdown = link.closest('.sidebar-dropdown');
                if (dropdown) {
                    dropdown.classList.add('show');
                }
                matchFound = true;
            }
        }
    });
});