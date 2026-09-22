<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();
if (!$noticia) { header('Location: listar.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim($_POST['titulo']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($titulo === '' || $fecha === '') throw new Exception('Título y fecha son obligatorios.');

        $fotoNueva = subir_imagen('foto', 'noticias');
        if ($fotoNueva) {
            borrar_archivo('noticias', $noticia['foto']);
            $foto = $fotoNueva;
        } else {
            $foto = $noticia['foto'];
        }

        $stmt = $pdo->prepare("UPDATE noticias SET titulo=?, foto=?, link_externo=?, fecha_publicacion=? WHERE id=?");
        $stmt->execute([$titulo, $foto, trim($_POST['link_externo']) ?: null, $fecha, $id]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $noticia = array_merge($noticia, $_POST);
    }
}
$tituloPagina = 'Editar noticia';
$seccionActiva = 'noticias';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Editar</strong> noticia</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?= h($noticia['titulo']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Enlace externo</label>
            <input type="url" name="link_externo" class="form-control" value="<?= h($noticia['link_externo']) ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Foto</label>
                <?php if ($noticia['foto']): ?><div class="mb-2"><img src="<?= BASE_URL ?>/uploads/noticias/<?= h($noticia['foto']) ?>" width="100" class="rounded"></div><?php endif; ?>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <div class="form-text">Deja vacío para conservar la foto actual.</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de publicación</label>
                <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($noticia['fecha_publicacion']) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
