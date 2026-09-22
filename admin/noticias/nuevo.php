<?php
require_once __DIR__ . '/../auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim($_POST['titulo']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($titulo === '' || $fecha === '') throw new Exception('Título y fecha son obligatorios.');

        $foto = subir_imagen('foto', 'noticias');

        $stmt = $pdo->prepare(
            "INSERT INTO noticias (titulo, foto, link_externo, fecha_publicacion, usuario_id) VALUES (?,?,?,?,?)"
        );
        $stmt->execute([$titulo, $foto, trim($_POST['link_externo']) ?: null, $fecha, $_SESSION['usuario_id']]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
$tituloPagina = 'Nueva noticia';
$seccionActiva = 'noticias';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Nueva</strong> noticia</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?= h($_POST['titulo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Enlace externo (Facebook, medio de prensa, etc.)</label>
            <input type="url" name="link_externo" class="form-control" placeholder="https://..." value="<?= h($_POST['link_externo'] ?? '') ?>">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de publicación</label>
                <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($_POST['fecha_publicacion'] ?? date('Y-m-d')) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
