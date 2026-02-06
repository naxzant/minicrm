<?php
// Simple Auth controller for admin area (login/logout)
class AuthController {

    public function showLogin() {
        require __DIR__ . '/../../views/admin/login.php';
    }

    public function login() {
        $cfg = require __DIR__ . '/../../config/admin.php';
        $user = isset($_POST['username']) ? trim($_POST['username']) : '';
        $pass = isset($_POST['password']) ? trim($_POST['password']) : '';

        if ($user === $cfg['username'] && $pass === $cfg['password']) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['admin_authenticated'] = true;
            $_SESSION['admin_username'] = $user;
            header('Location: admin.php');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['error'] = 'Invalid credentials';
        header('Location: admin.php?controller=auth&action=login');
        exit;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['admin_authenticated']);
        unset($_SESSION['admin_username']);
        header('Location: admin.php?controller=auth&action=login');
        exit;
    }
}

?>
