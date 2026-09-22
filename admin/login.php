<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/functions.php';

// Si ya inició sesión, mándalo directo al dashboard
if (!empty($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, nombres, ap_paterno, password_hash, rol FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($clave, $usuario['password_hash'])) {
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombres'] . ' ' . $usuario['ap_paterno'];
        $_SESSION['usuario_rol']    = $usuario['rol'];
        header('Location: ' . BASE_URL . '/admin/index.php');
        exit;
    }
    $error = 'Correo o contraseña incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ingresar - Panel DyD Perú</title>
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Diálogo y Desarrollo Perú</h1>
                        <p class="lead">Panel de administración de contenidos</p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?= h($error) ?></div>
                                <?php endif; ?>
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <input class="form-control form-control-lg" type="email" name="email" required autofocus>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <input class="form-control form-control-lg" type="password" name="password" required>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Ingresar</button>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="recuperar_password.php" class="text-muted">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="assets/js/app.js"></script>
</body>
</html>
