<?php
session_start();
require_once '../helpers/functions.php';
require_once '../helpers/logger.php';

if (isset($_SESSION['user'])) {
    logMessage("User logged out: " . $_SESSION['user']['email']);
}

session_unset();
session_destroy();
redirect('../views/login.php');
