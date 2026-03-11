<?php
require_once dirname(__DIR__) . '/includes/config.php';

require_once dirname(__DIR__) . '/includes/auth.php';
logout_user();
redirect(BASE_URL . "/index.php");
?>
