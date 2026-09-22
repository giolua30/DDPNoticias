<?php
require_once __DIR__ . '/../auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim($_POST['titulo']);
        $url    = trim($_POST['url_embed']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($titulo === '' || $url === '' || $fecha === '') throw new Exception('Todos los campos son obligatorios.');

        $stmt = $pdo->prepare("INSERT INTO videos (titulo, url_embed, fecha_publicacion, usuario_id) VALUES (?,?,?,?)");
        $stmt->execute([$titulo, $url, $fecha, $_SESSION['usuario_id']]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
$tituloPagina = 'Nuevo video';
$seccionActiva = 'videos';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Nuevo</strong> video</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?= h($_POST['titulo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Enlace embebido de YouTube (https://www.youtube.com/embed/...)</label>
            <input type="url" name="url_embed" class="form-control" required placeholder="https://..." value="<?= h($_POST['url_embed'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de publicación</label>
            <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($_POST['fecha_publicacion'] ?? date('Y-m-d')) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
