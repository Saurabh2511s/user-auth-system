<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .form-container { max-width: 500px; margin: 50px auto; }
        .error { color: red; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="container form-container">
    <h2 class="mb-4">User Registration</h2>
    <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
    <?php endif; ?>
    <form id="registerForm" method="POST" enctype="multipart/form-data" action="../process/register_process.php" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" id="name" required>
            <div class="error" id="nameErr"></div>
        </div>
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
        <div class="mb-3">
            <label for="confirm" class="form-label">Confirm Password *</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm" required>
            <div class="error" id="confirmErr"></div>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Upload File (PDF/JPG/PNG)</label>
            <input type="file" name="user_file" class="form-control" id="file">
            <div class="error" id="fileErr"></div>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Already have an account?</a>
    </form>
</div>

<script>
    $('#registerForm').on('submit', function (e) {
        let isValid = true;

        // Clear previous errors
        $('.error').text('');

        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const confirm = $('#confirm').val();
        const file = $('#file')[0].files[0];

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!name) {
            $('#nameErr').text("Name is required.");
            isValid = false;
        }

        if (!email || !emailRegex.test(email)) {
            $('#emailErr').text("Valid email is required.");
            isValid = false;
        }

        if (!password || password.length < 6) {
            $('#passwordErr').text("Password must be at least 6 characters.");
            isValid = false;
        }

        if (password !== confirm) {
            $('#confirmErr').text("Passwords do not match.");
            isValid = false;
        }

        if (file) {
            const allowed = ['application/pdf', 'image/jpeg', 'image/png'];
            if (!allowed.includes(file.type)) {
                $('#fileErr').text("Only PDF, JPG, or PNG allowed.");
                isValid = false;
            } else if (file.size > 2 * 1024 * 1024) {
                $('#fileErr').text("File must be less than 2MB.");
                isValid = false;
            }
        }

        if (!isValid) e.preventDefault();
    });
</script>
</body>
</html>
