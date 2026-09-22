<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Por favor, ingresa tu correo electrónico.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Generar token único de recuperación y fecha de expiración (1 hora)
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Guardar token en la BD (asegúrate de tener los campos token_recuperacion y token_expiracion en la tabla usuarios)
            $stmtUpd = $pdo->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expiracion = ? WHERE id = ?");
            $stmtUpd->execute([$token, $expira, $usuario['id']]);

            // Enlace de recuperación generado
            $enlace = BASE_URL . "/admin/restablecer_password.php?token=" . $token;

            // Nota: Aquí se enviaría el correo usando mail() o PHPMailer.
            // Para pruebas te mostramos el mensaje directo:
            $mensaje = "Se ha generado el enlace de recuperación: <a href='$enlace'>Restablecer contraseña</a>";
        } else {
            $error = 'No se encontró ninguna cuenta asociada a ese correo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container" style="max-width: 400px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Recuperar Contraseña</h4>

            <?php if ($mensaje): ?>
                <div class="alert alert-success"><?= $mensaje ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= h($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required placeholder="tu@correo.com">
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Volver al Login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>