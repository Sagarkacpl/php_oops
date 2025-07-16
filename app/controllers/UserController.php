<?php
require_once(__DIR__ . '/../models/Database.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../../functions.php');

class UserController {
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('username') !== null) {
            $db = new Database();
            $userModel = new User($db);
            $username = trim(post('username'));
            $result = $userModel->create($username);
            if (!$result) {
                // Debugging: Show error if user not created
                echo "Failed to create user. Please check your database connection, table structure, and error logs.";
                exit;
            }
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }

    public function edit($encryptedId) {
        $id = convert_string('decrypt', $encryptedId);
        $db = new Database();
        $userModel = new User($db);
        $user = $userModel->getById((int)$id);
        if (!$user) {
            header("Location: " . BASE_URL . "/admin/dashboard");
            exit;
        }
        require __DIR__ . '/../views/admin/edit_user.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('id') !== null && post('username') !== null) {
            $id = convert_string('decrypt', post('id'));
            $db = new Database();
            $userModel = new User($db);
            $userModel->update((int)$id, trim(post('username')));
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('id') !== null) {
            $id = convert_string('decrypt', post('id'));
            $db = new Database();
            $userModel = new User($db);
            $userModel->delete((int)$id);
        }
        header("Location: " . BASE_URL . "/admin/dashboard");
        exit;
    }
}
