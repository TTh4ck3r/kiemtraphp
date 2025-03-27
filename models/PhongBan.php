<?php
require_once 'Database.php';

class PhongBan {
    private $conn;
    private $table = 'PHONGBAN';

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Get all departments
    public function getAll() {
        $query = "SELECT Ma_Phong, Ten_Phong FROM " . $this->table . " ORDER BY Ten_Phong";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }
}
?>