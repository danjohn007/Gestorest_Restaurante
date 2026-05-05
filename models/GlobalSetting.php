<?php
class GlobalSetting extends BaseModel {
    protected $table = 'global_settings';
    
    public function get($key, $default = null) {
        $record = $this->findBy('setting_key', $key);
        return $record ? $record['setting_value'] : $default;
    }
    
    public function set($key, $value, $group = 'general', $description = null) {
        $existing = $this->findBy('setting_key', $key);
        if ($existing) {
            return $this->update($existing['id'], ['setting_value' => $value, 'setting_group' => $group]);
        } else {
            return $this->create([
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => $group,
                'description' => $description
            ]);
        }
    }
    
    public function getByGroup($group) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE setting_group = ? ORDER BY setting_key ASC");
        $stmt->execute([$group]);
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }
    
    public function getAllGrouped() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY setting_group, setting_key ASC");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_group']][$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }
}
