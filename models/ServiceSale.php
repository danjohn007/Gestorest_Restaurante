<?php
class ServiceSale extends BaseModel {
    protected $table = 'service_sales';

    public function getSalesWithDetails($filters = []) {
        $query = "SELECT ss.*, s.name AS service_name, s.category, u.name AS cashier_name
                  FROM {$this->table} ss
                  JOIN services s ON ss.service_id = s.id
                  JOIN users u ON ss.cashier_id = u.id
                  WHERE 1=1";
        $params = [];

        if (!empty($filters['date'])) {
            $query .= " AND DATE(ss.created_at) = ?";
            $params[] = $filters['date'];
        }

        if (!empty($filters['date_from'])) {
            $query .= " AND DATE(ss.created_at) >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $query .= " AND DATE(ss.created_at) <= ?";
            $params[] = $filters['date_to'];
        }

        if (!empty($filters['cashier_id'])) {
            $query .= " AND ss.cashier_id = ?";
            $params[] = $filters['cashier_id'];
        }

        $query .= " ORDER BY ss.created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTodaySales() {
        return $this->getSalesWithDetails(['date' => date('Y-m-d')]);
    }

    public function getTotalByDateRange($dateFrom, $dateTo) {
        $query = "SELECT COALESCE(SUM(subtotal), 0) AS total_sales, COUNT(*) AS total_records
                  FROM {$this->table}
                  WHERE DATE(created_at) BETWEEN ? AND ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$dateFrom, $dateTo]);
        return $stmt->fetch();
    }

    public function getDailyReport($date = null) {
        $date = $date ?: date('Y-m-d');
        $query = "SELECT s.name AS service_name, s.category,
                         SUM(ss.quantity) AS total_qty,
                         SUM(ss.subtotal) AS total_amount
                  FROM {$this->table} ss
                  JOIN services s ON ss.service_id = s.id
                  WHERE DATE(ss.created_at) = ?
                  GROUP BY ss.service_id
                  ORDER BY total_amount DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }
}
?>
