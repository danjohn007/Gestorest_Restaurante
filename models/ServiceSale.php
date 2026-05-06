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
            $conditions[] = "COALESCE(ss.reservation_date, DATE(ss.created_at)) = ?";
            $params[] = $filters['date'];
        }
        if (!empty($filters['date_from'])) {
            $conditions[] = "COALESCE(ss.reservation_date, DATE(ss.created_at)) >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $conditions[] = "COALESCE(ss.reservation_date, DATE(ss.created_at)) <= ?";
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
             WHERE COALESCE(reservation_date, DATE(created_at)) BETWEEN ? AND ?"
        );
        $stmt->execute([$dateFrom, $dateTo]);
        return $stmt->fetch();
    }

    public function getIncomeByDate($dateFrom, $dateTo) {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(reservation_date, DATE(created_at)) as date,
                    COALESCE(SUM(total), 0) as total_income,
                    COUNT(*) as total_sales
             FROM {$this->table}
             WHERE COALESCE(reservation_date, DATE(created_at)) BETWEEN ? AND ?
             GROUP BY COALESCE(reservation_date, DATE(created_at))
             ORDER BY COALESCE(reservation_date, DATE(created_at)) ASC"
        );
        $stmt->execute([$dateFrom, $dateTo]);
        return $stmt->fetchAll();
    }

    public function getIncomeByPaymentMethod($dateFrom, $dateTo) {
        $stmt = $this->db->prepare(
            "SELECT payment_method,
                    COUNT(*) as services_count,
                    COALESCE(SUM(total), 0) as total_income
             FROM {$this->table}
             WHERE COALESCE(reservation_date, DATE(created_at)) BETWEEN ? AND ?
             GROUP BY payment_method
             ORDER BY total_income DESC"
        );
        $stmt->execute([$dateFrom, $dateTo]);
        return $stmt->fetchAll();
    }

    public function getDailyTotal($date = null) {
        $date = $date ?: date('Y-m-d');
        $stmt = $this->db->prepare(
            "SELECT COALESCE(SUM(total), 0) as total_income, COUNT(*) as total_count
             FROM {$this->table}
             WHERE COALESCE(reservation_date, DATE(created_at)) = ?"
        );
        $stmt->execute([$date]);
        return $stmt->fetch();
    }

    public function getPopularServices($limit = 5) {
        $stmt = $this->db->prepare(
            "SELECT s.name, s.category,
                    COUNT(ss.id) as total_sales,
                    COALESCE(SUM(ss.total), 0) as total_revenue
             FROM {$this->table} ss
             JOIN services s ON ss.service_id = s.id
             GROUP BY ss.service_id, s.name, s.category
             ORDER BY total_sales DESC
             LIMIT ?"
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
