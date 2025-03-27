<!-- helpers/logger.php -->
<?php
function logMessage($message) {
    $logFile = __DIR__ . '/../logs/app.log';
    $date = date('Y-m-d H:i:s');
    $msg = "[$date] $message" . PHP_EOL;
    file_put_contents($logFile, $msg, FILE_APPEND);
}
?>
