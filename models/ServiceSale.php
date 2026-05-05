<?php
class ServiceSale extends BaseModel {
    protected $table = 'service_sales';
    
    public function getSalesWithDetails($filters = []) {
        $query = "SELECT ss.*, s.name as service_name, s.category, u.name as cashier_name
                  FROM {$this->table} ss
                  JOIN services s ON ss.service_id = s.id
                  JOIN users u ON ss.user_id = u.id";
        $conditions = [];
        $params = [];
        
        if (!empty($filters['date'])) {
            $conditions[] = "DATE(ss.created_at) = ?";
            $params[] = $filters['date'];
        }
        if (!empty($filters['date_from'])) {
            $conditions[] = "DATE(ss.created_at) >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "DATE(ss.created_at) <= ?";
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['user_id'])) {
            $conditions[] = "ss.user_id = ?";
            $params[] = $filters['user_id'];
        }
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        $query .= " ORDER BY ss.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getTotalByDateRange($dateFrom, $dateTo) {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(total), 0) as total_income, COUNT(*) as total_sales
             FROM {$this->table}
             WHERE DATE(created_at) BETWEEN ? AND ?"
        );
        $stmt->execute([$dateFrom, $dateTo]);
        return $stmt->fetch();
    }
}
