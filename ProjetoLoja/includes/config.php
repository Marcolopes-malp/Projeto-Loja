<?php
if (!defined('BASE_URL')) {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $app_root = strpos($script_name, '/pages/') !== false ? dirname(dirname($script_name)) : dirname($script_name);
    $app_root = rtrim(str_replace('\\', '/', $app_root), '/');
    define('BASE_URL', $app_root);
}
