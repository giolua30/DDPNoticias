<?php
require_once __DIR__ . '/auth.php';

$contadores = [];
foreach (['reportajes', 'noticias', 'boletines', 'podcasts', 'videos'] as $tabla) {
    $contadores[$tabla] = (int) $pdo->query("SELECT COUNT(*) FROM $tabla")->fetchColumn();
}

$ultimosReportajes = $pdo->query(
    "SELECT id, titulo, fecha_publicacion, es_destacado
     FROM reportajes ORDER BY created_at DESC LIMIT 5"
)->fetchAll();

$tituloPagina = 'Dashboard';
$seccionActiva = 'dashboard';
require __DIR__ . '/partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Panel</strong> Diálogo y Desarrollo Perú</h1>

<div class="row">
    <div class="col-sm-6 col-xl-2 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Reportajes</h5>
                <h1 class="display-6"><?= $contadores['reportajes'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Noticias</h5>
                <h1 class="display-6"><?= $contadores['noticias'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Boletines</h5>
                <h1 class="display-6"><?= $contadores['boletines'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Podcasts</h5>
                <h1 class="display-6"><?= $contadores['podcasts'] ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Videos</h5>
                <h1 class="display-6"><?= $contadores['videos'] ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Últimos reportajes cargados</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Destacado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$ultimosReportajes): ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">Aún no has publicado ningún reportaje.</td></tr>
                <?php endif; ?>
                <?php foreach ($ultimosReportajes as $r): ?>
                    <tr>
                        <td><?= h($r['titulo']) ?></td>
                        <td><?= h($r['fecha_publicacion']) ?></td>
                        <td><?= $r['es_destacado'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td class="text-end">
                            <a href="reportajes/editar.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
