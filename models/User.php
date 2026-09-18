<?php
class User {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function create($name, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'Local Explorer';
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hash, $role);
        if (!$stmt->execute()) return false;
        return $stmt->insert_id;
    }

    public function createExplorer($userId, $location, $bio) {
        $stmt = $this->conn->prepare("INSERT INTO local_explorer (user_id, location, bio) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $location, $bio);
        return $stmt->execute();
    }

    public function getExplorerByUser($userId) {
        $stmt = $this->conn->prepare("SELECT le.*, u.name, u.email FROM local_explorer le JOIN users u ON u.id = le.user_id WHERE le.user_id = ? LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
