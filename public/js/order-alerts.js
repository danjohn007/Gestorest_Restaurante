/**
 * Order Alert System for Admin and Cashier Dashboard
 * Monitors for new orders and displays alerts with sound notifications
 */

class OrderAlertSystem {
    constructor() {
        this.lastCheck = new Date().toISOString().slice(0, 19).replace('T', ' ');
        this.checkInterval = 10000; // Check every 10 seconds
        this.isPlaying = false;
        this.activeAlerts = new Set();
        this.audio = null;
        this.audioContext = null;
        
        this.init();
    }
    
    init() {
        // Create alert container
        this.createAlertContainer();
        
        // Start polling for new orders
        this.startPolling();
        
        // Enable audio context on first user interaction
        this.enableAudioOnInteraction();
    }
    
    enableAudioOnInteraction() {
        const enableAudio = () => {
            if (!this.audioContext) {
                this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            // Remove listeners after first interaction
            document.removeEventListener('click', enableAudio);
            document.removeEventListener('keydown', enableAudio);
        };
        
        document.addEventListener('click', enableAudio);
        document.addEventListener('keydown', enableAudio);
    }
    
    playNotificationSound() {
        if (this.isPlaying || !this.audioContext) return;
        
        this.isPlaying = true;
        
        // Create elegant notification sound using Web Audio API
        const ctx = this.audioContext;
        const now = ctx.currentTime;
        
        // Create oscillators for a pleasant chord
        const frequencies = [523.25, 659.25, 783.99]; // C5, E5, G5 - Major chord
        
        frequencies.forEach((freq, index) => {
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(ctx.destination);
            
            oscillator.frequency.value = freq;
            oscillator.type = 'sine';
            
            // Envelope: smooth attack and decay
            gainNode.gain.setValueAtTime(0, now);
            gainNode.gain.linearRampToValueAtTime(0.15, now + 0.05);
            gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.5);
            
            oscillator.start(now + (index * 0.1));
            oscillator.stop(now + 0.7);
        });
        
        // Loop the sound every 3 seconds until dismissed
        setTimeout(() => {
            this.isPlaying = false;
            if (this.activeAlerts.size > 0) {
                this.playNotificationSound();
            }
        }, 3000);
    }
    
    createAlertContainer() {
        if (!document.getElementById('order-alerts-container')) {
            const container = document.createElement('div');
            container.id = 'order-alerts-container';
            container.style.cssText = `
                position: fixed;
                top: 80px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 9999;
                width: 90%;
                max-width: 800px;
                pointer-events: none;
            `;
            
            document.body.appendChild(container);
        }
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    showAlert(order) {
        // Avoid duplicate alerts
        if (this.activeAlerts.has(order.id)) {
            return;
        }
        
        this.activeAlerts.add(order.id);
        
        const container = document.getElementById('order-alerts-container');
        const alert = document.createElement('div');
        alert.id = `alert-${order.id}`;
        alert.className = 'alert alert-warning alert-dismissible fade show shadow-lg';
        alert.style.cssText = `
            pointer-events: auto;
            margin-bottom: 10px;
            animation: slideDown 0.3s ease-out;
            border-left: 5px solid #ffc107;
            background: linear-gradient(135deg, #fff3cd 0%, #fff8e1 100%);
        `;
        
        // Sanitize all user-provided data
        const orderId = parseInt(order.id) || 0;
        const tableName = order.table_number ? `Mesa ${this.escapeHtml(String(order.table_number))}` : 'Para llevar';
        const waiterName = this.escapeHtml(order.waiter_name || 'Sin asignar');
        const itemsCount = parseInt(order.items_count) || 0;
        const createdAt = this.formatTime(order.created_at);
        
        alert.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <i class="bi bi-bell-fill text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading mb-1">
                        <i class="bi bi-exclamation-circle-fill"></i> ¡Nuevo Pedido Recibido!
                    </h5>
                    <p class="mb-1">
                        <strong>Pedido #${orderId}</strong> - ${tableName}
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> ${waiterName} | 
                        <i class="bi bi-clock"></i> ${createdAt} |
                        <i class="bi bi-list"></i> ${itemsCount} items
                    </small>
                </div>
                <div class="flex-shrink-0 ms-3">
                    <a href="${window.BASE_URL}/orders/show/${orderId}" 
                       class="btn btn-warning btn-lg"
                       onclick="orderAlertSystem.dismissAlert(${orderId})">
                        <i class="bi bi-eye"></i> Ver Pedido
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" onclick="orderAlertSystem.dismissAlert(${orderId})" 
                    aria-label="Close"></button>
        `;
        
        container.appendChild(alert);
        
        // Play notification sound
        this.playNotificationSound();
    }
    
    dismissAlert(orderId) {
        this.activeAlerts.delete(orderId);
        const alert = document.getElementById(`alert-${orderId}`);
        if (alert) {
            alert.style.animation = 'slideUp 0.3s ease-in';
            setTimeout(() => alert.remove(), 300);
        }
        
        // Stop sound if no more active alerts
        if (this.activeAlerts.size === 0) {
            this.isPlaying = false;
        }
    }
    
    formatTime(datetime) {
        const date = new Date(datetime);
        return date.toLocaleTimeString('es-MX', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
    }
    
    async checkNewOrders() {
        // Skip check if page is not visible
        if (document.hidden) {
            return;
        }
        
        try {
            const response = await fetch(
                `${window.BASE_URL}/dashboard/checkNewOrders?last_check=${encodeURIComponent(this.lastCheck)}`
            );
            
            if (!response.ok) {
                console.error('Error checking new orders:', response.statusText);
                return;
            }
            
            const data = await response.json();
            
            if (data.count > 0) {
                // Show alerts for each new order
                data.new_orders.forEach(order => {
                    this.showAlert(order);
                });
            }
            
            // Update last check timestamp
            this.lastCheck = data.timestamp;
            
        } catch (error) {
            console.error('Error checking new orders:', error);
        }
    }
    
    startPolling() {
        // Initial check
        this.checkNewOrders();
        
        // Poll every 10 seconds
        setInterval(() => {
            this.checkNewOrders();
        }, this.checkInterval);
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
`;
document.head.appendChild(style);

// Initialize the alert system when DOM is ready
let orderAlertSystem;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        orderAlertSystem = new OrderAlertSystem();
    });
} else {
    orderAlertSystem = new OrderAlertSystem();
}
