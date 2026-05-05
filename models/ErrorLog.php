<?php
class ErrorLog extends BaseModel {
    protected $table = 'error_logs';
    
    public function logError($type, $message, $file = null, $line = null, $stackTrace = null) {
        return $this->create([
            'error_type' => $type,
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'stack_trace' => $stackTrace,
            'url' => $_SERVER['REQUEST_URI'] ?? null
        ]);
    }
    
    public function clearAll() {
        $stmt = $this->db->prepare("DELETE FROM {$this->table}");
        $stmt->execute();
        return true;
    }
    
    public function getRecentErrors($limit = 100) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
