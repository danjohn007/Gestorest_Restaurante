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
        
        this.init();
    }
    
    init() {
        // Create audio element with elegant notification sound
        this.createAudioElement();
        
        // Create alert container
        this.createAlertContainer();
        
        // Start polling for new orders
        this.startPolling();
    }
    
    createAudioElement() {
        // Use a pleasant notification sound frequency
        // We'll use the Web Audio API to generate an elegant tone
        this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
    }
    
    playNotificationSound() {
        if (this.isPlaying) return;
        
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
        
        const tableName = order.table_number ? `Mesa ${order.table_number}` : 'Para llevar';
        const waiterName = order.waiter_name || 'Sin asignar';
        
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
                        <strong>Pedido #${order.id}</strong> - ${tableName}
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> ${waiterName} | 
                        <i class="bi bi-clock"></i> ${this.formatTime(order.created_at)} |
                        <i class="bi bi-list"></i> ${order.items_count} items
                    </small>
                </div>
                <div class="flex-shrink-0 ms-3">
                    <a href="${window.BASE_URL}/orders/show/${order.id}" 
                       class="btn btn-warning btn-lg"
                       onclick="orderAlertSystem.dismissAlert(${order.id})">
                        <i class="bi bi-eye"></i> Ver Pedido
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" onclick="orderAlertSystem.dismissAlert(${order.id})" 
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
