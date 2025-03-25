<?php
session_start();
require_once '../config/db.php';
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';

try {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Backend validation
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please fill in all fields.";
        redirect('../views/login.php');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        logMessage("Failed login attempt for email: $email");
        $_SESSION['login_error'] = "Invalid email or password.";
        redirect('../views/login.php');
    }

    // Success - Set session
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'file_path' => $user['file_path']
    ];

    logMessage("User logged in: $email");

    redirect('../views/dashboard.php');

} catch (Exception $e) {
    logMessage("Login Error: " . $e->getMessage());
    $_SESSION['login_error'] = "Unexpected error. Please try again.";
    redirect('../views/login.php');
}
