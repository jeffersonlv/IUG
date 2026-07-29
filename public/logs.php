<?php
// TEMPORARY debug tool — remove after diagnosing 500 error.
$token = 'iug_dbg_9kQ2xVnR7pL4mZaT';

if (($_GET['token'] ?? '') !== $token) {
    http_response_code(403);
    exit('forbidden');
}

$logFile = __DIR__ . '/../storage/logs/laravel.log';

header('Content-Type: text/plain; charset=utf-8');

if (!file_exists($logFile)) {
    exit('log file not found: ' . $logFile);
}

$lines = (int) ($_GET['lines'] ?? 200);
$content = file($logFile);
$slice = array_slice($content, -$lines);
echo implode('', $slice);
