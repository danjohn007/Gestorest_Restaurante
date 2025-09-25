<?php $title = 'Ticket de Cocina #' . $order['id']; ?>

<div class="no-print d-flex justify-content-between align-items-center mb-3">
    <h4>Ticket de Cocina #<?= $order['id'] ?></h4>
    <div>
        <a href="<?= BASE_URL ?>/orders" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</div>

<div class="ticket">
    <div class="ticket-header">
        <h2>TICKET DE COCINA</h2>
        <div class="order-info">
            <div><strong>PEDIDO #<?= $order['id'] ?></strong></div>
            <div><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></div>
            <?php if (!empty($order['table_name'])): ?>
            <div><strong>Mesa: <?= htmlspecialchars($order['table_name']) ?></strong></div>
            <?php endif; ?>
            <div>Mesero: <?= htmlspecialchars($order['waiter_name'] ?? 'No asignado') ?></div>
        </div>
    </div>

    <div class="ticket-separator">================================</div>
    
    <div class="ticket-items">
        <?php if (!empty($order['items'])): ?>
            <?php foreach ($order['items'] as $item): ?>
            <div class="item">
                <div class="item-line">
                    <span class="quantity"><?= $item['quantity'] ?>x</span>
                    <span class="dish-name"><?= htmlspecialchars($item['dish_name']) ?></span>
                </div>
                <?php if (!empty($item['notes'])): ?>
                <div class="item-notes">
                    ** NOTA: <?= htmlspecialchars($item['notes']) ?> **
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-items">No hay platillos en este pedido</div>
        <?php endif; ?>
    </div>
    
    <div class="ticket-separator">================================</div>
    
    <div class="ticket-footer">
        <div>Estado: <?= $order['status'] ?></div>
        <div class="print-time">Impreso: <?= date('d/m/Y H:i:s') ?></div>
    </div>
</div>

<style>
    .ticket {
        width: 80mm;
        max-width: 300px;
        margin: 0 auto;
        font-family: 'Arial Black', 'Arial', sans-serif;
        font-size: 14px;
        line-height: 1.4;
        color: #000;
        background: #fff;
        padding: 12px;
        border: 1px solid #000;
    }
    
    .ticket-header {
        text-align: center;
        margin-bottom: 10px;
    }
    
    .ticket-header h2 {
        font-size: 20px;
        font-weight: 900;
        margin: 0 0 10px 0;
        letter-spacing: 1px;
        color: #000;
    }
    
    .order-info {
        text-align: center;
        font-size: 14px;
        font-weight: 700;
    }
    
    .order-info div {
        margin: 3px 0;
    }
    
    .ticket-separator {
        text-align: center;
        font-weight: 900;
        margin: 12px 0;
        font-size: 14px;
        color: #000;
    }
    
    .ticket-items {
        margin: 12px 0;
    }
    
    .item {
        margin-bottom: 10px;
    }
    
    .item-line {
        display: flex;
        align-items: flex-start;
        margin-bottom: 3px;
    }
    
    .quantity {
        font-weight: 900;
        min-width: 35px;
        font-size: 16px;
        color: #000;
    }
    
    .dish-name {
        flex: 1;
        font-weight: 900;
        font-size: 15px;
        color: #000;
    }
    
    .item-notes {
        margin-left: 35px;
        font-size: 13px;
        font-style: italic;
        color: #000;
        padding: 3px 0;
        font-weight: 700;
    }
    
    .ticket-footer {
        text-align: center;
        font-size: 13px;
        margin-top: 14px;
        font-weight: 700;
        color: #000;
    }
    
    .ticket-footer div {
        margin: 3px 0;
    }
    
    .print-time {
        font-style: italic;
        font-size: 12px;
    }
    
    .no-items {
        text-align: center;
        font-style: italic;
        font-weight: 700;
        color: #000;
    }
    
    @media print {
        .no-print { 
            display: none !important; 
        }
        
        body { 
            margin: 0;
            padding: 0;
            background: #fff;
        }
        
        .ticket {
            width: 80mm;
            max-width: none;
            border: none;
            margin: 0;
            padding: 5mm;
        }
        
        .ticket-header h2 {
            font-size: 22px;
        }
        
        .quantity {
            font-size: 18px;
        }
        
        .dish-name {
            font-size: 16px;
        }
        
        .item-notes {
            font-size: 14px;
        }
    }
</style>
