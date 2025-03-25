<?php
session_start();
require_once '../helpers/functions.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 600px; margin-top: 50px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?> 👋</h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <?php if (!empty($user['file_path'])): ?>
        <p><strong>Uploaded File:</strong>
            <a href="../public/uploads/<?= $user['file_path'] ?>" target="_blank">View File</a>
        </p>
    <?php else: ?>
        <p><em>No file uploaded.</em></p>
    <?php endif; ?>

    <a href="../process/logout.php" class="btn btn-danger mt-3">Logout</a>
</div>
</body>
</html>
