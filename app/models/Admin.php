<?php
require_once(__DIR__ . '/../models/Database.php');

class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkCredentials($username, $password) {
        // Hash the plain-text password with MD5
        
        $passwordHash = md5($password);
        // Safe SQL with prepared statements
        $sql = "SELECT * FROM admins WHERE username = :username AND password = :password LIMIT 1";
        try {
            $pdo = $this->db->getConnection(); 
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
            $stmt->execute();

            // Debugging: Uncomment below to see what is being checked
            // $debugSql = str_replace(
            //     [':username', ':password'],
            //     [var_export($username, true), var_export($passwordHash, true)],
            //     $sql
            // );
            // echo $debugSql;
            // exit;

            if ($stmt->rowCount() > 0) {
                
                // Return user data for session storage
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return false;

        } catch (PDOException $e) {
            // Log the error securely (never show raw DB error to users)
            error_log('Login error: ' . $e->getMessage());
            return false;
        }
    }
}
