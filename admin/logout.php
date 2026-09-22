<?php
session_start();
$_SESSION = [];
session_destroy();
require_once __DIR__ . '/../config.php';
header('Location: ' . BASE_URL . '/admin/login.php');
exit;
