<?php
namespace App\Middleware;
session_start();

class AuthMiddleware{

    protected function checkLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    protected function checkRole($requiredRole) {
        $this->checkLoggedIn();
        if ($_SESSION['role'] !== $requiredRole) {
            header('Location: /');
            exit();
        }
    }

}