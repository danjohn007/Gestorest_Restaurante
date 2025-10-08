<?php
class TableZone extends BaseModel {
    protected $table = 'table_zones';
    
    public function getAllActive() {
        return $this->findAll(['active' => 1], 'name ASC');
    }
    
    public function nameExists($name, $excludeId = null) {
        $query = "SELECT id FROM {$this->table} WHERE name = ?";
        $params = [$name];
        
        if ($excludeId) {
            $query .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetch() !== false;
    }
    
    public function getZoneUsageStats() {
        $query = "SELECT 
                    tz.name as zone_name,
                    tz.color as zone_color,
                    COUNT(t.id) as total_tables,
                    COUNT(CASE WHEN t.status = 'ocupada' THEN 1 END) as occupied_tables
                  FROM {$this->table} tz
                  LEFT JOIN tables t ON tz.name = t.zone AND t.active = 1
                  WHERE tz.active = 1
                  GROUP BY tz.id, tz.name, tz.color
                  ORDER BY tz.name ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function getZonesForLayout() {
        $query = "SELECT id, name, color, position_x, position_y, width, height 
                  FROM {$this->table} 
                  WHERE active = 1 
                  ORDER BY name ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function updateZoneArea($id, $x, $y, $width, $height) {
        return $this->update($id, [
            'position_x' => (int)$x,
            'position_y' => (int)$y,
            'width' => (int)$width,
            'height' => (int)$height
        ]);
    }
}
?>