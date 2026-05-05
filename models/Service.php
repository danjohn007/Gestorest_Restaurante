<?php
class Service extends BaseModel {
    protected $table = 'services';

    public function getAllActive() {
        return $this->findAll(['active' => 1], 'name ASC');
    }

    public function getCategories() {
        $query = "SELECT DISTINCT category FROM {$this->table} WHERE active = 1 AND category IS NOT NULL AND category != '' ORDER BY category ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return array_column($stmt->fetchAll(), 'category');
    }

    public function getServicesWithFilters($filters = []) {
        $query = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!isset($filters['include_inactive'])) {
            $query .= " AND active = 1";
        }

        if (!empty($filters['search'])) {
            $query .= " AND (name LIKE ? OR description LIKE ? OR category LIKE ?)";
            $term = '%' . $filters['search'] . '%';
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        if (!empty($filters['category'])) {
            $query .= " AND category = ?";
            $params[] = $filters['category'];
        }

        $query .= " ORDER BY name ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
