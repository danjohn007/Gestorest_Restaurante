<?php
class ReservationEmailTemplate {
    
    public static function buildConfirmationEmail($data) {
        $siteName = htmlspecialchars($data['site_name'] ?? 'Restaurante');
        $customerName = htmlspecialchars($data['customer_name'] ?? '');
        $customerEmail = htmlspecialchars($data['customer_email'] ?? '');
        $customerPhone = htmlspecialchars($data['customer_phone'] ?? '');
        $tables = htmlspecialchars($data['tables'] ?? 'Por asignar');
        $datetime = $data['datetime'] ?? '';
        $date = date('d/m/Y', strtotime($datetime));
        $time = date('H:i', strtotime($datetime));
        $partySize = htmlspecialchars($data['party_size'] ?? '1');
        $status = htmlspecialchars($data['status'] ?? 'PENDIENTE');
        $notes = htmlspecialchars($data['notes'] ?? '—');
        $contactEmail = htmlspecialchars($data['contact_email'] ?? '');
        $contactWebsite = htmlspecialchars($data['contact_website'] ?? '');
        
        // Map status to Spanish
        $statusMap = [
            'pendiente' => 'PENDIENTE',
            'confirmada' => 'CONFIRMADO',
            'cancelada' => 'CANCELADO',
            'completada' => 'COMPLETADO'
        ];
        $statusDisplay = strtoupper($statusMap[$status] ?? $status);
        
        $html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reservación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #2d5016;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header .icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .header .subtitle {
            font-size: 16px;
            margin-top: 10px;
            font-weight: normal;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .details-section {
            background-color: #f9f9f9;
            border-left: 4px solid #2d5016;
            padding: 20px;
            margin: 20px 0;
        }
        .details-section h2 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #2d5016;
            display: flex;
            align-items: center;
        }
        .details-section h2 .icon {
            margin-right: 8px;
        }
        .detail-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
            min-width: 120px;
        }
        .detail-value {
            color: #333;
            flex: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }
        .status-confirmado {
            background-color: #28a745;
            color: #ffffff;
        }
        .status-pendiente {
            background-color: #ffc107;
            color: #000000;
        }
        .contact-section {
            background-color: #e9f5ff;
            border-left: 4px solid #0066cc;
            padding: 20px;
            margin: 20px 0;
        }
        .contact-section h2 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #0066cc;
            display: flex;
            align-items: center;
        }
        .contact-section h2 .icon {
            margin-right: 8px;
        }
        .contact-info {
            margin: 8px 0;
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
        }
        .footer-note {
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="icon">🏨</div>
            <h1>' . $siteName . '</h1>
            <div class="subtitle">Confirmación de Reservación</div>
        </div>
        
        <div class="content">
            <div class="greeting">
                Estimado/a <strong>' . $customerName . '</strong>,<br><br>
                ¡Gracias por elegir ' . $siteName . '! Nos complace confirmar que hemos recibido su reservación.
            </div>
            
            <div class="details-section">
                <h2><span class="icon">📋</span> Detalles de su Reservación</h2>
                
                <div class="detail-row">
                    <div class="detail-label">Tipo:</div>
                    <div class="detail-value">🍽️ Reservación Restaurante</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Cliente:</div>
                    <div class="detail-value">' . $customerName . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">' . $customerEmail . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Teléfono:</div>
                    <div class="detail-value">' . $customerPhone . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Recurso:</div>
                    <div class="detail-value">' . $tables . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Fecha:</div>
                    <div class="detail-value">' . $date . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Hora:</div>
                    <div class="detail-value">' . $time . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Personas:</div>
                    <div class="detail-value">' . $partySize . '</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Estado:</div>
                    <div class="detail-value"><span class="status-badge status-' . strtolower($statusDisplay) . '">' . $statusDisplay . '</span></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Notas:</div>
                    <div class="detail-value">' . nl2br($notes) . '</div>
                </div>
            </div>';
        
        if (!empty($contactEmail) || !empty($contactWebsite)) {
            $html .= '
            <div class="contact-section">
                <h2><span class="icon">📞</span> Información de Contacto</h2>';
            
            if (!empty($contactEmail)) {
                $html .= '<div class="contact-info"><strong>Email:</strong> ' . $contactEmail . '</div>';
            }
            
            if (!empty($contactWebsite)) {
                $html .= '<div class="contact-info"><strong>Sitio Web:</strong> ' . $contactWebsite . '</div>';
            }
            
            $html .= '</div>';
        }
        
        $html .= '
            <div class="footer-note">
                Si necesita modificar o cancelar su reservación, por favor contáctenos lo antes posible.<br>
                ¡Esperamos recibirle pronto en ' . $siteName . '!
            </div>
        </div>
        
        <div class="footer">
            © ' . date('Y') . ' ' . $siteName . '. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>';
        
        return $html;
    }
}
