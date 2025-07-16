<?php
session_start();

class AdminController {
    // public function login() {
    //     if(isset($_SESSION['admin'])) {
    //         header("Location: " . BASE_URL . "/admin/dashboard");
    //         exit;
    //     }
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $u = $_POST['username'];
    //         $p = $_POST['password'];

    //         if ($u === 'admin' && $p === 'admin123') {
    //             $_SESSION['admin'] = true;
    //             header("Location: " . BASE_URL . "/admin/dashboard");
    //             exit;
    //         } else {
    //             $error = "Invalid Credentials";
    //         }
    //     }
    //     require '../app/views/admin/login.php';
    // }
    public function login() {
        // Check DB connection
        require_once '../app/models/Database.php';
        $db = new Database();

        if (isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "/admin/dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = $_POST['username'];
            $p = $_POST['password'];

            require_once(__DIR__ . '/../models/Admin.php');
            require_once(__DIR__ . '/../models/Database.php');
            $db = new Database();
            $adminModel = new Admin($db);

            $user = $adminModel->checkCredentials($u, $p);
            if ($user) {
                $_SESSION['userid'] = $user['id']; // or 'admin_id' depending on your table
                $_SESSION['username'] = $user['username'];
                header("Location: " . BASE_URL . "/admin/dashboard");
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        }

        require '../app/views/admin/login.php';
    }


    public function dashboard() {
        if (!isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "/admin/login");
            exit;
        }

        require '../app/views/admin/dashboard.php';
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/admin/login");
    }
}