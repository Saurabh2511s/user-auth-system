<?php
session_start();
require_once '../config/db.php';
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';

try {
    // Sanitize and fetch form inputs
    $name     = sanitizeInput($_POST['name'] ?? '');
    $email    = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Strong password regex
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?#&]).{8,}$/";

    // Backend validations
    if (!$name || !$email || !$password || !$confirm) {
        $_SESSION['register_error'] = "All fields are required.";
        redirect('../views/register.php');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email format.";
        redirect('../views/register.php');
    }

    if (!preg_match($pattern, $password)) {
        $_SESSION['register_error'] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        redirect('../views/register.php');
    }

    if ($password !== $confirm) {
        $_SESSION['register_error'] = "Passwords do not match.";
        redirect('../views/register.php');
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['register_error'] = "Email already registered.";
        redirect('../views/register.php');
    }

    // Handle file upload
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
            $_SESSION['register_error'] = "Failed to upload file.";
            logMessage("File upload failed for $email.");
            redirect('../views/register.php');
        }

        $uploadedFilePath = $uniqueName;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into database
    $insert = $pdo->prepare("INSERT INTO users (name, email, password, file_path) VALUES (?, ?, ?, ?)");
    $insert->execute([$name, $email, $hashedPassword, $uploadedFilePath]);

    logMessage("User registered: $email");

    $_SESSION['register_success'] = "Registration successful. Please login.";
    redirect('../views/login.php');

} catch (Exception $e) {
    logMessage("Registration error for $email: " . $e->getMessage());
    $_SESSION['register_error'] = "Unexpected error occurred. Please try again.";
    redirect('../views/register.php');
}
