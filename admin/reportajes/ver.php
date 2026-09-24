<?php
require_once __DIR__ . '/../auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
    SELECT r.*, a.nickname, a.nombres, a.ap_paterno 
    FROM reportajes r 
    LEFT JOIN autores a ON r.autor_id = a.id 
    WHERE r.id = ?
");
$stmt->execute([$id]);
$reportaje = $stmt->fetch();

if (!$reportaje) {
    header('Location: listar.php');
    exit;
}

// Incluimos tu header administrativo existente
include_once __DIR__ . '/../partials/header.php'; // Ajusta la ruta a tu parcial si varía
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Previsualización de Reportaje</h2>
        <span class="badge <?php echo $reportaje['estado'] === 'publicado' ? 'bg-success' : 'bg-warning text-dark'; ?>">
            Estado: <?php echo strtoupper($reportaje['estado']); ?>
        </span>
    </div>
    <div>
        <a href="editar.php?id=<?php echo $reportaje['id']; ?>" class="btn btn-primary">Editar</a>
        <a href="listar.php" class="btn btn-outline-secondary">Volver a la lista</a>
    </div>
</div>

<div class="card shadow-sm p-4 bg-white mb-4">
    <h1 class="fw-bold mb-3"><?php echo htmlspecialchars($reportaje['titulo']); ?></h1>
    
    <div class="text-muted mb-3">
        <strong>Autor:</strong> <?php echo htmlspecialchars($reportaje['nickname'] ?: ($reportaje['nombres'] . ' ' . $reportaje['ap_paterno'])); ?> | 
        <strong>Fecha:</strong> <?php echo $reportaje['fecha_publicacion']; ?>
    </div>

    <?php if (!empty($reportaje['foto_principal'])): ?>
        <div class="mb-4 text-center">
            <img src="../../uploads/<?php echo htmlspecialchars($reportaje['foto_principal']); ?>" class="img-fluid rounded border" style="max-height: 400px;" alt="Foto principal">
        </div>
    <?php endif; ?>

    <div class="p-3 bg-light rounded border mb-3">
        <strong>Resumen corto:</strong>
        <p class="mb-0 text-secondary"><?php echo htmlspecialchars($reportaje['resumen_corto']); ?></p>
    </div>

    <hr>

    <div class="contenido-desarrollo">
        <?php echo $reportaje['desarrollo']; ?>
    </div>
</div>

<?php 
// Incluimos tu footer administrativo existente
include_once __DIR__ . '/../partials/footer.php'; 
?>