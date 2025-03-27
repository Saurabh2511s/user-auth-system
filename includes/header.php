<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "User Auth System" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .form-container { max-width: 600px; margin: 50px auto; }
        .error { color: red; font-size: 0.9rem; }
        .navbar { margin-bottom: 30px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">User System</a>
        <div class="d-flex">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="navbar-text text-white me-3">Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                <a class="btn btn-outline-light btn-sm" href="../process/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
