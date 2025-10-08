<?php
class LayoutSymbol extends BaseModel {
    protected $table = 'layout_symbols';
    
    /**
     * Get all symbols
     */
    public function getAllSymbols() {
        $query = "SELECT * FROM {$this->table} ORDER BY type ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Update symbol position
     */
    public function updatePosition($id, $x, $y) {
        return $this->update($id, [
            'position_x' => (int)$x,
            'position_y' => (int)$y
        ]);
    }
    
    /**
     * Reset symbol positions to default
     */
    public function resetPositions() {
        $defaultPositions = [
            'puerta' => ['x' => 50, 'y' => 50],
            'entrada' => ['x' => 200, 'y' => 50],
            'barra' => ['x' => 350, 'y' => 50],
            'caja' => ['x' => 500, 'y' => 50],
            'cocina' => ['x' => 650, 'y' => 50]
        ];
        
        try {
            $this->db->beginTransaction();
            
            foreach ($defaultPositions as $type => $pos) {
                $symbol = $this->findBy('type', $type);
                if ($symbol) {
                    $this->updatePosition($symbol['id'], $pos['x'], $pos['y']);
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
?>
