<?php
session_start();
require_once '../helpers/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    redirect('login.php');
}

$user = $_SESSION['user'];
$title = "Dashboard";

include '../includes/header.php';
?>

<div class="container form-container">
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?> 👋</h2>

    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <?php if (!empty($user['file_path'])): ?>
        <p><strong>Uploaded File:</strong>
            <a href="../public/uploads/<?= htmlspecialchars($user['file_path']) ?>" target="_blank">View File</a>
        </p>
    <?php else: ?>
        <p><em>No file uploaded.</em></p>
    <?php endif; ?>

    <a href="../process/logout.php" class="btn btn-danger mt-3">Logout</a>
</div>

<?php include '../includes/footer.php'; ?>
