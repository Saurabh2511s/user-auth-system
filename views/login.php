<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .form-container { max-width: 500px; margin: 50px auto; }
        .error { color: red; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="container form-container">
    <h2 class="mb-4">User Login</h2>
    <?php if (isset($_SESSION['register_success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['register_success']; unset($_SESSION['register_success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>
    <form id="loginForm" method="POST" action="../process/login_process.php" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email address *</label>
            <input type="email" name="email" class="form-control" id="email" required>
            <div class="error" id="emailErr"></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="error" id="passwordErr"></div>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Don't have an account?</a>
    </form>
</div>

<script>
    $('#loginForm').on('submit', function (e) {
        let isValid = true;
        $('.error').text('');

        const email = $('#email').val().trim();
        const password = $('#password').val();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !emailRegex.test(email)) {
            $('#emailErr').text("Valid email is required.");
            isValid = false;
        }

        if (!password || password.length < 6) {
            $('#passwordErr').text("Password must be at least 6 characters.");
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });
</script>
</body>
</html>
