<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Static method to authenticate user
    public static function authenticate($email, $password) {
        global $db;
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email, md5($password)]); // Note: In a real app, use proper password hashing
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by ID
    public static function getById($id) {
        global $db;
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new user
    public static function create($data) {
        global $db;
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            md5($data['password']) // Note: In a real app, use proper password hashing
        ]);
    }

    // Update user profile
    public static function update($id, $data) {
        global $db;
        $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $id
        ]);
    }
}
