<?php
require_once __DIR__ . '/../auth.php';

$autores = $pdo->query("SELECT id, nickname, nombres, ap_paterno, es_nickname FROM autores ORDER BY nombres")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo        = trim($_POST['titulo']);
        $resumen_corto = trim($_POST['resumen_corto']);
        $desarrollo    = trim($_POST['desarrollo']);
        $fecha         = $_POST['fecha_publicacion'];
        $destacado     = isset($_POST['es_destacado']) ? 1 : 0;
        $autor_id      = (int) $_POST['autor_id'];

        if ($titulo === '' || $desarrollo === '' || $fecha === '') {
            throw new Exception('Título, desarrollo y fecha son obligatorios.');
        }

        $foto = subir_imagen('foto_principal', 'reportajes');
        $pdf  = subir_pdf('pdf_adjunto', 'reportajes');

        $stmt = $pdo->prepare(
            "INSERT INTO reportajes
                (titulo, resumen_corto, desarrollo, foto_principal, pdf_adjunto,
                 fecha_publicacion, es_destacado, autor_id, usuario_id)
             VALUES (?,?,?,?,?,?,?,?,?)"
        );
        $stmt->execute([
            $titulo, $resumen_corto, $desarrollo, $foto, $pdf,
            $fecha, $destacado, $autor_id, $_SESSION['usuario_id'],
        ]);

        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$tituloPagina = 'Nuevo reportaje';
$seccionActiva = 'reportajes';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Nuevo</strong> reportaje</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= h($error) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required
                       value="<?= h($_POST['titulo'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Resumen corto (aparece en las tarjetas de la portada)</label>
                <textarea name="resumen_corto" class="form-control" rows="2"><?= h($_POST['resumen_corto'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Desarrollo completo de la nota</label>
                <textarea name="desarrollo" class="form-control" rows="10" required><?= h($_POST['desarrollo'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto principal</label>
                    <input type="file" name="foto_principal" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">PDF adjunto (opcional)</label>
                    <input type="file" name="pdf_adjunto" class="form-control" accept="application/pdf">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de publicación</label>
                    <input type="date" name="fecha_publicacion" class="form-control" required
                           value="<?= h($_POST['fecha_publicacion'] ?? date('Y-m-d')) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Autor</label>
                    <select name="autor_id" class="form-select">
                        <?php foreach ($autores as $a): ?>
                            <option value="<?= $a['id'] ?>">
                                <?= h($a['es_nickname'] ? $a['nickname'] : $a['nombres'] . ' ' . $a['ap_paterno']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="es_destacado" id="destacado">
                        <label class="form-check-label" for="destacado">Mostrar como destacado en portada</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar reportaje</button>
            <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
