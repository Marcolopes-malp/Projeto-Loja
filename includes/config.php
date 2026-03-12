<?php
if (!defined('BASE_URL')) {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $app_root = strpos($script_name, '/pages/') !== false ? dirname(dirname($script_name)) : dirname($script_name);
    $app_root = rtrim(str_replace('\\', '/', $app_root), '/');
    define('BASE_URL', $app_root);
    
    // DEBUG 404 ROOT CAUSE
    file_put_contents(__DIR__ . '/url_debug.log', date('Y-m-d H:i:s') . " - SCRIPT_NAME: " . $script_name . " -> BASE_URL: " . $app_root . " -> REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? '') . "\n", FILE_APPEND);
}
