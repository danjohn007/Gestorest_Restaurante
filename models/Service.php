<?php
class Service extends BaseModel {
    protected $table = 'services';
    
    public function getAllActive() {
        return $this->findAll(['active' => 1], 'name ASC');
    }
    
    public function search($term) {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE active = 1 AND (name LIKE ? OR category LIKE ? OR description LIKE ?) ORDER BY name ASC"
        );
        $like = '%' . $term . '%';
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll();
    }
    
    public function getCategories() {
        $stmt = $this->db->prepare("SELECT DISTINCT category FROM {$this->table} WHERE active = 1 AND category IS NOT NULL ORDER BY category ASC");
        $stmt->execute();
        return array_column($stmt->fetchAll(), 'category');
    }
}
