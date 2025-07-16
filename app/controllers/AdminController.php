<?php
session_start();
require_once(__DIR__ . '/../models/Database.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../../functions.php'); // Make sure convert_string is available

class AdminController {
    public function login() {
     
        // Check DB connection
        require_once '../app/models/Database.php';
        

        if (isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "/admin/dashboard");
            exit;
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $u = $_POST['username'];
            $p = $_POST['password'];

            // Encrypt credentials for debug only
            $encryptedUsername = convert_string('encrypt', $u);
            $encryptedPassword = convert_string('encrypt', $p);


            // echo "<script>console.log('Encrypted Username: " . addslashes($encryptedUsername) . "');</script>";
            // echo "<script>console.log('Encrypted Password: " . addslashes($encryptedPassword) . "');</script>";

            require_once(__DIR__ . '/../models/Admin.php');
            $db = new Database();
            $adminModel = new Admin($db);

            // Pass original credentials for DB check
            $user = $adminModel->checkCredentials($u, $p);
            if ($user) {
                $_SESSION['admin'] = true;
                $_SESSION['userid'] = $user['id']; // or 'admin_id' depending on your table
                $_SESSION['username'] = $user['username'];
                // header("Location: " . BASE_URL . "/admin/dashboard");
                // exit;
                echo "<div style='color: green; font-weight: bold;'>Login successfully. Redirecting to dashboard...</div>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = '" . BASE_URL . "/admin/dashboard';
                        }, 5000);
                      </script>";
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
        $db = new Database();
        $userModel = new User($db);
        $users = $userModel->getAll();
        require '../app/views/admin/dashboard.php';
    }

    public function usersCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
            $db = new Database();
            $userModel = new User($db);
            $userModel->create(trim($_POST['username']));
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }

    public function usersUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['username'])) {
            $db = new Database();
            $userModel = new User($db);
            $userModel->update((int)$_POST['id'], trim($_POST['username']));
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }

    public function usersDelete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $db = new Database();
            $userModel = new User($db);
            $userModel->delete((int)$_POST['id']);
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/admin/login");
    }

    public function index() {
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }
}

if ($controller == 'admin' && $method == 'users' && $action == 'create') {
    (new AdminController())->usersCreate();
}