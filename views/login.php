<?php
session_start();
$title = "Login";
include '../includes/header.php';
?>
<div class="container form-container">
    <h2 class="mb-4">User Login</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>
    <form id="loginForm" method="POST" action="../process/login_process.php" novalidate>
        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" id="email">
            <div class="error" id="emailErr"></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" id="password">
            <div class="error" id="passwordErr"></div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Don't have an account?</a>
    </form>
</div>
<script src="../public/js/validation.js"></script>
<script>
    $('#loginForm').on('submit', function (e) {
        const fields = {
            email: $('#email').val(),
            password: $('#password').val()
        };
        if (!validateForm(fields)) e.preventDefault();
    });
</script>
<?php include '../includes/footer.php'; ?>