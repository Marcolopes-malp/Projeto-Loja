<?php
$script_name = '/ProjetoLoja/ProjetoLoja/pages/favoritos.php';
$app_root = strpos($script_name, '/pages/') !== false ? dirname(dirname($script_name)) : dirname($script_name);
$app_root = rtrim(str_replace('\\', '/', $app_root), '/');
echo "1. " . $app_root . "\n";

$script_name2 = '/pages/favoritos.php';
$app_root2 = strpos($script_name2, '/pages/') !== false ? dirname(dirname($script_name2)) : dirname($script_name2);
$app_root2 = rtrim(str_replace('\\', '/', $app_root2), '/');
echo "2. " . $app_root2 . "\n";
?>
