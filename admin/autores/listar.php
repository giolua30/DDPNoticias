<?php
require_once __DIR__ . '/../auth.php';

$autores = $pdo->query("SELECT * FROM autores ORDER BY nombres")->fetchAll();

$tituloPagina = 'Autores';
$seccionActiva = 'autores';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"><strong>Autores</strong></h1>
    <a href="nuevo.php" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Nuevo autor</a>
</div>

<?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Los cambios se guardaron correctamente.</div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">No se puede eliminar un autor que ya tiene reportajes asignados.</div>
<?php endif; ?>

<div class="card">
    <table class="table table-hover my-0">
        <thead>
        <tr>
            <th>Nombre / Nickname</th>
            <th>Se muestra como</th>
            <th class="text-end">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$autores): ?>
            <tr><td colspan="3" class="text-center text-muted py-4">No hay autores registrados.</td></tr>
        <?php endif; ?>
        <?php foreach ($autores as $a): ?>
            <tr>
                <td><?= h(trim($a['nombres'] . ' ' . $a['ap_paterno'] . ' ' . $a['ap_materno'])) ?><?= $a['nickname'] ? ' ("' . h($a['nickname']) . '")' : '' ?></td>
                <td><?= $a['es_nickname'] ? '<span class="badge bg-info">Nickname</span>' : '<span class="badge bg-secondary">Nombre completo</span>' ?></td>
                <td class="text-end">
                    <a href="editar.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="eliminar.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('¿Eliminar este autor?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
