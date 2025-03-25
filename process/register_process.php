<?php
session_start();

require_once '../config/db.php';
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';


try {
    // Sanitize Inputs
    $name     = sanitizeInput($_POST['name'] ?? '');
    $email    = sanitizeInput($_POST['email'] ?? '');

    
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Backend Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $_SESSION['register_error'] = "All required fields must be filled.";
        redirect('../views/register.php');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
        redirect('../views/register.php');
    }

    if (strlen($password) < 6) {
        $_SESSION['register_error'] = "Password must be at least 6 characters.";
        redirect('../views/register.php');
    }

    if ($password !== $confirm) {
        $_SESSION['register_error'] = "Passwords do not match.";
        redirect('../views/register.php');
    }
    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['register_error'] = "Email already exists.";
        redirect('../views/register.php');
    }

    // Handle File Upload
    $uploadedFilePath = null;
    if (!empty($_FILES['user_file']['name'])) {
        $fileTmp  = $_FILES['user_file']['tmp_name'];
        $fileName = basename($_FILES['user_file']['name']);
        $fileSize = $_FILES['user_file']['size'];
        $fileType = mime_content_type($fileTmp);
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['register_error'] = "Only PDF, JPG, or PNG files are allowed.";
            redirect('../views/register.php');
        }

        if ($fileSize > 2 * 1024 * 1024) {
            $_SESSION['register_error'] = "File size must be less than 2MB.";
            redirect('../views/register.php');
        }

        $uniqueName = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
        $destination = '../public/uploads/' . $uniqueName;

        if (!move_uploaded_file($fileTmp, $destination)) {
            $_SESSION['register_error'] = "File upload failed.";
            logMessage("File upload failed for user: $email");
            redirect('../views/register.php');
        }

        $uploadedFilePath = $uniqueName;
    }

    // Hash Password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert User
    $insert = $pdo->prepare("INSERT INTO users (name, email, password, file_path) VALUES (?, ?, ?, ?)");
    $insert->execute([$name, $email, $hashedPassword, $uploadedFilePath]);

    logMessage("New user registered: $email");

    $_SESSION['register_success'] = "Registration successful. Please login.";
    redirect('../views/login.php');

} catch (Exception $e) {
    logMessage("Error in register_process: " . $e->getMessage());
    $_SESSION['register_error'] = "Unexpected error occurred. Try again.";
    redirect('../views/register.php');
}
