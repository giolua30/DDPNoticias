<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM podcasts WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) { header('Location: listar.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim($_POST['titulo']);
        $url    = trim($_POST['url_embed']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($titulo === '' || $url === '' || $fecha === '') throw new Exception('Todos los campos son obligatorios.');

        $stmt = $pdo->prepare("UPDATE podcasts SET titulo=?, url_embed=?, fecha_publicacion=? WHERE id=?");
        $stmt->execute([$titulo, $url, $fecha, $id]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $item = array_merge($item, $_POST);
    }
}
$tituloPagina = 'Editar episodio';
$seccionActiva = 'podcasts';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Editar</strong> episodio de podcast</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?= h($item['titulo']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Enlace embebido</label>
            <input type="url" name="url_embed" class="form-control" required value="<?= h($item['url_embed']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de publicación</label>
            <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($item['fecha_publicacion']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
