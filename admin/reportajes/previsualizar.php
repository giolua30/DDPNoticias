<?php
require_once 'conexion.php'; // Usa tu archivo de conexión principal

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT r.*, a.nickname, a.nombres FROM reportajes r LEFT JOIN autores a ON r.autor_id = a.id WHERE r.id = ?");
$stmt->execute([$id]);
$reportaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reportaje) {
    die("El reportaje no existe o fue eliminado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Previa: <?php echo htmlspecialchars($reportaje['titulo']); ?></title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>
<body>
    <div class="alert alert-warning text-center rounded-0 mb-0" role="alert">
        <strong>Modo Previsualización:</strong> Este reporte está en estado <strong><?php echo strtoupper($reportaje['estado']); ?></strong> y solo es visible por ti.
    </div>

    <div class="container py-5">
        <h1 class="fw-bold"><?php echo htmlspecialchars($reportaje['titulo']); ?></h1>
        <p class="text-muted">Autor: <?php echo htmlspecialchars($reportaje['nickname'] ?: $reportaje['nombres']); ?></p>

        <?php if (!empty($reportaje['foto_principal'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($reportaje['foto_principal']); ?>" class="img-fluid rounded mb-4 shadow-sm" alt="Foto principal">
        <?php endif; ?>

        <div class="contenido-reportaje mt-3">
            <?php echo $reportaje['desarrollo']; ?>
        </div>
    </div>
</body>
</html>