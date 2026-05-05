<?php
class ActionLog extends BaseModel {
    protected $table = 'action_logs';
    
    public function log($userId, $action, $entityType = null, $entityId = null, $description = null) {
        return $this->create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    }
    
    public function getLogsWithDetails($filters = []) {
        $query = "SELECT al.*, u.name as user_name, u.role as user_role
                  FROM {$this->table} al
                  LEFT JOIN users u ON al.user_id = u.id";
        $conditions = [];
        $params = [];
        
        if (!empty($filters['date_from'])) {
            $conditions[] = "DATE(al.created_at) >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "DATE(al.created_at) <= ?";
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['user_id'])) {
            $conditions[] = "al.user_id = ?";
            $params[] = $filters['user_id'];
        }
        if (!empty($filters['action'])) {
            $conditions[] = "al.action LIKE ?";
            $params[] = '%' . $filters['action'] . '%';
        }
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        $query .= " ORDER BY al.created_at DESC LIMIT 500";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
