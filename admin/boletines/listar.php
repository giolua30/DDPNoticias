<?php
require_once __DIR__ . '/../auth.php';
$boletines = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC, id DESC")->fetchAll();

$tituloPagina = 'Boletín NTEP';
$seccionActiva = 'boletines';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"><strong>Boletín NTEP</strong></h1>
    <a href="nuevo.php" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Nuevo boletín</a>
</div>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">Los cambios se guardaron correctamente.</div><?php endif; ?>
<?php if (isset($_GET['error'])): ?><div class="alert alert-danger">Ya existe un boletín con ese número.</div><?php endif; ?>
<div class="card">
    <table class="table table-hover my-0">
        <thead><tr><th style="width:70px">Portada</th><th>N° Boletín</th><th>Resumen</th><th>Fecha</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>
        <?php if (!$boletines): ?><tr><td colspan="5" class="text-center text-muted py-4">No hay boletines registrados.</td></tr><?php endif; ?>
        <?php foreach ($boletines as $b): ?>
            <tr>
                <td><?php if ($b['foto_portada']): ?><img src="<?= BASE_URL ?>/uploads/boletines/<?= h($b['foto_portada']) ?>" width="50" height="50" class="rounded" style="object-fit:cover"><?php endif; ?></td>
                <td><?= h($b['numero_boletin']) ?></td>
                <td><?= h(resumir($b['resumen'], 60)) ?></td>
                <td><?= h($b['fecha_publicacion']) ?></td>
                <td class="text-end">
                    <a href="<?= BASE_URL ?>/uploads/boletines/<?= h($b['archivo_pdf']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">PDF</a>
                    <a href="editar.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="eliminar.php?id=<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este boletín?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
