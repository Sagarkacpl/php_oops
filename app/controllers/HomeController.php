<?php

class HomeController {
    public function index() {
        require '../app/views/home.php';
    }

    public function user($id) {
        require '../app/views/user.php';
    }
}