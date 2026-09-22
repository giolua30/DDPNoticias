<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

$token = $_GET['token'] ?? '';
$error = '';
$exito = false;

if (empty($token)) {
    die('Token no válido.');
}

// Validar que el token exista y no haya expirado
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token_recuperacion = ? AND token_expiracion > NOW()");
$stmt->execute([$token]);
$usuario = $stmt->fetch();

if (!$usuario) {
    $error = 'El enlace de recuperación es inválido o ha expirado.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuario) {
    $nuevaClave = $_POST['password'] ?? '';
    $confirmar  = $_POST['confirm_password'] ?? '';

    if (empty($nuevaClave) || strlen($nuevaClave) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($nuevaClave !== $confirmar) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $hash = password_hash($nuevaClave, PASSWORD_BCRYPT);
        // Actualizar clave y limpiar token
        $stmtUpd = $pdo->prepare("UPDATE usuarios SET password_hash = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE id = ?");
        $stmtUpd->execute([$hash, $usuario['id']]);

        $exito = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
<div class="container" style="max-width: 400px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Nueva Contraseña</h4>

            <?php if ($exito): ?>
                <div class="alert alert-success">
                    ¡Contraseña actualizada con éxito! <br>
                    <a href="login.php" class="fw-bold">Iniciar sesión aquí</a>.
                </div>
            <?php else: ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= h($error) ?></div>
                <?php endif; ?>

                <?php if ($usuario): ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
                    </form>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>