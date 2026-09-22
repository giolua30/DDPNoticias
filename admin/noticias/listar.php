<?php
require_once __DIR__ . '/../auth.php';
$noticias = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC, id DESC")->fetchAll();

$tituloPagina = 'Noticias';
$seccionActiva = 'noticias';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"><strong>Noticias</strong></h1>
    <a href="nuevo.php" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Nueva noticia</a>
</div>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">Los cambios se guardaron correctamente.</div><?php endif; ?>
<div class="card">
    <table class="table table-hover my-0">
        <thead><tr><th style="width:70px">Foto</th><th>Título</th><th>Enlace externo</th><th>Fecha</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>
        <?php if (!$noticias): ?><tr><td colspan="5" class="text-center text-muted py-4">No hay noticias registradas.</td></tr><?php endif; ?>
        <?php foreach ($noticias as $n): ?>
            <tr>
                <td><?php if ($n['foto']): ?><img src="<?= BASE_URL ?>/uploads/noticias/<?= h($n['foto']) ?>" width="50" height="50" class="rounded" style="object-fit:cover"><?php endif; ?></td>
                <td><?= h($n['titulo']) ?></td>
                <td><?php if ($n['link_externo']): ?><a href="<?= h($n['link_externo']) ?>" target="_blank">Ver enlace</a><?php endif; ?></td>
                <td><?= h($n['fecha_publicacion']) ?></td>
                <td class="text-end">
                    <a href="editar.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="eliminar.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta noticia?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
