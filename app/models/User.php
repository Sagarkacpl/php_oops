<?php

require_once(__DIR__ . '/../../functions.php');
require_once(__DIR__ . '/../models/Database.php');

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($username) {
        $username = trim($username);
        if ($username === '') {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO users (username) VALUES (:username)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            // Debugging: Output error info
            $errorInfo = $stmt->errorInfo();
            echo "DB Error: " . implode(' | ', $errorInfo);
            return false;
        }
        return true;
    }

    public function update($id, $username) {
        $stmt = $this->db->prepare("UPDATE users SET username = :username WHERE id = :id");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
