<?php
/**
 * Incluir este archivo al inicio de toda página del panel que requiera
 * que el usuario haya iniciado sesión.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

if (empty($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}
