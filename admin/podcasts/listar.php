<?php
require_once __DIR__ . '/../auth.php';
$items = $pdo->query("SELECT * FROM podcasts ORDER BY fecha_publicacion DESC, id DESC")->fetchAll();

$tituloPagina = 'Podcast';
$seccionActiva = 'podcasts';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"><strong>Podcast</strong></h1>
    <a href="nuevo.php" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Nuevo episodio</a>
</div>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">Los cambios se guardaron correctamente.</div><?php endif; ?>
<div class="card">
    <table class="table table-hover my-0">
        <thead><tr><th>Título</th><th>Enlace embebido</th><th>Fecha</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>
        <?php if (!$items): ?><tr><td colspan="4" class="text-center text-muted py-4">No hay episodios registrados.</td></tr><?php endif; ?>
        <?php foreach ($items as $it): ?>
            <tr>
                <td><?= h($it['titulo']) ?></td>
                <td><a href="<?= h($it['url_embed']) ?>" target="_blank">Ver enlace</a></td>
                <td><?= h($it['fecha_publicacion']) ?></td>
                <td class="text-end">
                    <a href="editar.php?id=<?= $it['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="eliminar.php?id=<?= $it['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este episodio?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
