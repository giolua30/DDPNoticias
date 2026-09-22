<?php
require_once __DIR__ . '/../auth.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM reportajes WHERE id = ?");
$stmt->execute([$id]);
$reportaje = $stmt->fetch();

if (!$reportaje) {
    header('Location: listar.php');
    exit;
}

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

        // Si suben un archivo nuevo, reemplaza el anterior; si no, se conserva el que ya había
        $fotoNueva = subir_imagen('foto_principal', 'reportajes');
        if ($fotoNueva) {
            borrar_archivo('reportajes', $reportaje['foto_principal']);
            $foto = $fotoNueva;
        } else {
            $foto = $reportaje['foto_principal'];
        }

        $pdfNuevo = subir_pdf('pdf_adjunto', 'reportajes');
        if ($pdfNuevo) {
            borrar_archivo('reportajes', $reportaje['pdf_adjunto']);
            $pdf = $pdfNuevo;
        } else {
            $pdf = $reportaje['pdf_adjunto'];
        }

        $stmt = $pdo->prepare(
            "UPDATE reportajes SET
                titulo = ?, resumen_corto = ?, desarrollo = ?, foto_principal = ?,
                pdf_adjunto = ?, fecha_publicacion = ?, es_destacado = ?, autor_id = ?
             WHERE id = ?"
        );
        $stmt->execute([
            $titulo, $resumen_corto, $desarrollo, $foto, $pdf,
            $fecha, $destacado, $autor_id, $id,
        ]);

        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
        $reportaje = array_merge($reportaje, $_POST); // conserva lo escrito si algo falla
    }
}

$tituloPagina = 'Editar reportaje';
$seccionActiva = 'reportajes';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Editar</strong> reportaje</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= h($error) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required
                       value="<?= h($reportaje['titulo']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Resumen corto</label>
                <textarea name="resumen_corto" class="form-control" rows="2"><?= h($reportaje['resumen_corto']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Desarrollo completo</label>
                <textarea name="desarrollo" class="form-control" rows="10" required><?= h($reportaje['desarrollo']) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto principal</label>
                    <?php if ($reportaje['foto_principal']): ?>
                        <div class="mb-2">
                            <img src="<?= BASE_URL ?>/uploads/reportajes/<?= h($reportaje['foto_principal']) ?>" width="120" class="rounded">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto_principal" class="form-control" accept="image/*">
                    <div class="form-text">Deja vacío para conservar la foto actual.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">PDF adjunto</label>
                    <?php if ($reportaje['pdf_adjunto']): ?>
                        <div class="mb-2">
                            <a href="<?= BASE_URL ?>/uploads/reportajes/<?= h($reportaje['pdf_adjunto']) ?>" target="_blank">Ver PDF actual</a>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="pdf_adjunto" class="form-control" accept="application/pdf">
                    <div class="form-text">Deja vacío para conservar el PDF actual.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de publicación</label>
                    <input type="date" name="fecha_publicacion" class="form-control" required
                           value="<?= h($reportaje['fecha_publicacion']) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Autor</label>
                    <select name="autor_id" class="form-select">
                        <?php foreach ($autores as $a): ?>
                            <option value="<?= $a['id'] ?>" <?= $a['id'] == $reportaje['autor_id'] ? 'selected' : '' ?>>
                                <?= h($a['es_nickname'] ? $a['nickname'] : $a['nombres'] . ' ' . $a['ap_paterno']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="es_destacado" id="destacado"
                               <?= $reportaje['es_destacado'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="destacado">Mostrar como destacado en portada</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
