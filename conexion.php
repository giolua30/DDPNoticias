<?php
/**
 * Alias de compatibilidad: si en tu código usas require 'conexion.php',
 * esto simplemente carga la configuración real (config.php) para que
 * la variable $pdo esté disponible igual. No dupliques datos de conexión
 * aquí: todo se edita en config.php.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';
