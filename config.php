<?php
/**
 * Configuración general del sitio y conexión a la base de datos.
 * EDITA los datos de abajo según tu XAMPP / hosting.
 */

// ---- Datos de conexión a MySQL ----
define('DB_HOST', 'localhost');
define('DB_NAME', 'revista_digital');
define('DB_USER', 'root');   // en XAMPP normalmente es 'root'
define('DB_PASS', '');       // en XAMPP normalmente está vacío

// ---- Ruta base del sitio (sin barra al final) ----
// Ejemplo local XAMPP si la carpeta se llama "dyd-cms": http://localhost/dyd-cms
// Ejemplo en tu hosting real: https://www.dialogoydesarrollo.com.pe
define('BASE_URL', 'http://localhost/dyd-cms');

date_default_timezone_set('America/Lima');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die('No se pudo conectar a la base de datos: ' . $e->getMessage());
}
