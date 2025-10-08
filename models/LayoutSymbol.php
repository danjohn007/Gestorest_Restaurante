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
    
    /**
     * Duplicate a symbol
     * Creates a copy of an existing symbol with a slightly offset position
     */
    public function duplicateSymbol($id) {
        try {
            // Get the original symbol
            $original = $this->find($id);
            
            if (!$original) {
                return false;
            }
            
            // Find the next available number for this type
            $query = "SELECT label FROM {$this->table} WHERE type = ? ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$original['type']]);
            $existingSymbols = $stmt->fetchAll();
            
            // Count how many of this type exist
            $count = count($existingSymbols) + 1;
            
            // Create the new symbol with offset position
            $newData = [
                'type' => $original['type'],
                'label' => $original['label'] . ' ' . $count,
                'position_x' => $original['position_x'] + 30,
                'position_y' => $original['position_y'] + 30,
                'icon' => $original['icon']
            ];
            
            return $this->create($newData);
            
        } catch (Exception $e) {
            error_log("Error duplicating symbol: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete a symbol (only if it's a duplicate)
     * Prevents deletion of original symbols
     */
    public function deleteSymbol($id) {
        try {
            $symbol = $this->find($id);
            
            if (!$symbol) {
                return false;
            }
            
            // Check if there are multiple symbols of this type
            $query = "SELECT COUNT(*) as count FROM {$this->table} WHERE type = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$symbol['type']]);
            $result = $stmt->fetch();
            
            // Only allow deletion if there are multiple symbols of this type
            if ($result['count'] > 1) {
                return $this->delete($id);
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("Error deleting symbol: " . $e->getMessage());
            return false;
        }
    }
}
?>
