<?php
session_start();
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';

// Log the logout if user is set
if (isset($_SESSION['user'])) {
    logMessage("User logged out: " . $_SESSION['user']['email']);
}

// Clear session and redirect
session_unset();
session_destroy();
redirect('../views/login.php');
