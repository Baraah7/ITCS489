<?php
class UserModel {
    private $db;

    public function __construct() {
        require_once '../app/core/database.php';
        $this->db = new Database();
    }

    public function getUserById($userId) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $userId);
        return $this->db->single();
    }
}
?>
