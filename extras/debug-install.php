#!/usr/bin/env php
<?php
/**
 * Debug Helper for HyperShipX Installer
 * Runs the installer with Xdebug enabled
 */

// Check if app name is provided
if ($argc < 2) {
    die("Usage: php debug-install.php <appname> [seed]\n");
}

// Build the command
$command = "php -dxdebug.mode=debug -dxdebug.start_with_request=yes -dxdebug.client_host=127.0.0.1 -dxdebug.client_port=9003 -dxdebug.idekey=PHPSTORM extras/install.php " . escapeshellarg($argv[1]);

// Add seed parameter if provided
if (isset($argv[2]) && $argv[2] === 'seed') {
    $command .= " seed";
}

// Run the command
echo "🔍 Starting installer with Xdebug enabled...\n";
echo "🔧 Command: $command\n\n";
system($command);