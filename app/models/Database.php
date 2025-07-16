<?php
require_once(__DIR__ . '/../../config.php');

class Database {
    protected $db;

    public function __construct() {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function isConnected() {
        return $this->db instanceof PDO;
    }

    public function getConnection() {
        return $this->db;
    }
    // ...existing code...
}