<?php
require_once __DIR__ . '/../auth.php';

$reportajes = $pdo->query(
    "SELECT r.id, r.titulo, r.fecha_publicacion, r.es_destacado, r.foto_principal, r.estado,
            COALESCE(a.nickname, CONCAT(a.nombres,' ',a.ap_paterno)) AS autor
     FROM reportajes r
     LEFT JOIN autores a ON a.id = r.autor_id
     ORDER BY r.fecha_publicacion DESC, r.id DESC"
)->fetchAll();

$tituloPagina = 'Reportajes';
$seccionActiva = 'reportajes';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"><strong>Reportajes</strong></h1>
    <a href="nuevo.php" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Nuevo reportaje</a>
</div>

<?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Los cambios se guardaron correctamente.</div>
<?php endif; ?>

<div class="card">
    <table class="table table-hover my-0">
        <thead>
        <tr>
            <th style="width:70px">Foto</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Destacado</th>
            <th class="text-end">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!$reportajes): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">No hay reportajes registrados todavía.</td></tr>
        <?php endif; ?>
        <?php foreach ($reportajes as $r): ?>
        <tr>
            <td>
                <?php if ($r['foto_principal']): ?>
                    <img src="<?= BASE_URL ?>/uploads/reportajes/<?= h($r['foto_principal']) ?>" class="rounded" width="50" height="50" style="object-fit:cover;">
                <?php endif; ?>
            </td>
            <td><?= h($r['titulo']) ?></td>
            <td><?= h($r['autor']) ?></td>
            <td><?= h($r['fecha_publicacion']) ?></td>
            
            <!-- 1. CELDA DE ESTADO (AUMENTADO SIN CAMBIAR TU ESTILO) -->
            <td>
                <?php if (isset($r['estado']) && strtolower(trim($r['estado'])) === 'borrador'): ?>
                    <span class="badge bg-warning text-dark">Borrador</span>
                <?php else: ?>
                    <span class="badge bg-success">Publicado</span>
                <?php endif; ?>
            </td>

            <td><?= $r['es_destacado'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
            
            <td class="text-end">
                <!-- 2. BOTÓN VER (AUMENTADO JUNTO A TUS BOTONES EDITAR Y ELIMINAR) -->
                <a href="ver.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-info">Ver</a>
                <a href="editar.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                <a href="eliminar.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger"
                onclick="return confirm('¿Seguro que deseas eliminar este reportaje? Esta acción no se puede deshacer.');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
