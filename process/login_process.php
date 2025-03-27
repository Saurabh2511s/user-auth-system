<?php
session_start();
require_once '../config/db.php';
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';

try {
    // Sanitize form inputs
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Both email and password are required.";
        redirect('../views/login.php');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Invalid email format.";
        redirect('../views/login.php');
    }

    // Fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify user and password
    if (!$user || !password_verify($password, $user['password'])) {
        logMessage("Failed login attempt for $email");
        $_SESSION['login_error'] = "Invalid email or password.";
        redirect('../views/login.php');
    }

    // Set session
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'file_path' => $user['file_path']
    ];

    logMessage("User logged in: $email");

    // Redirect to dashboard
    redirect('../views/dashboard.php');

} catch (Exception $e) {
    logMessage("Login error for $email: " . $e->getMessage());
    $_SESSION['login_error'] = "Unexpected error occurred. Please try again.";
    redirect('../views/login.php');
}
