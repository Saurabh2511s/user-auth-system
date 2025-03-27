<?php
session_start();
$title = "Register";
include '../includes/header.php';
?>
<div class="container form-container">
    <h2 class="mb-4">User Registration</h2>
    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
    <?php endif; ?>
    <form id="registerForm" method="POST" enctype="multipart/form-data" action="../process/register_process.php" novalidate>
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" id="name">
            <div class="error" id="nameErr"></div>
        </div>
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
        <div class="mb-3">
            <label class="form-label">Confirm Password *</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm">
            <div class="error" id="confirmErr"></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="user_file" class="form-control" id="file">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Already have an account?</a>
    </form>
</div>
<script src="../public/js/validation.js"></script>
<script>
    $('#registerForm').on('submit', function (e) {
        const fields = {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            confirm: $('#confirm').val()
        };
        if (!validateForm(fields)) e.preventDefault();
    });
</script>
<?php include '../includes/footer.php'; ?>