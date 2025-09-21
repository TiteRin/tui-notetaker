#!/usr/bin/env php
<?php
// apps/cli/daemon.php

// --- CONFIG ---
$port = getenv('POC_PORT') ?: 8000;
$pidFile = __DIR__ . '/frankenphp.pid';

// Determine monorepo root (assuming apps/cli is 2 levels below root)
$monorepoRoot = dirname(__DIR__, 2);
$backendDir = $monorepoRoot . '/apps/api/public';

// --- CHECK IF BACKEND IS ALREADY RUNNING ---
if (file_exists($pidFile)) {
    $pid = (int)file_get_contents($pidFile);
    if ($pid > 0 && posix_kill($pid, 0)) {
        echo "Backend already running (PID $pid).\n";
        exit(0);
    } else {
        echo "Found stale PID file. Removing...\n";
        unlink($pidFile);
    }
}

// --- START FRANKENPHP ---
echo "Starting FrankenPHP backend...\n";

$cmd = sprintf(
    'frankenphp php-server --root=%s --listen=:%d > /dev/null 2>&1 & echo $!',
    escapeshellarg($backendDir),
    $port
);

echo "$cmd\n";

// Launch backend
$pid = (int)shell_exec($cmd);

// Save PID
file_put_contents($pidFile, $pid);

echo "Backend started (PID $pid). Waiting for it to be ready...\n";
sleep(3); // simple wait, can improve with a health-check loop

echo "Backend ready on port $port.\n";

