<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM boletines WHERE id = ?");
$stmt->execute([$id]);
$boletin = $stmt->fetch();
if (!$boletin) { header('Location: listar.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $numero = trim($_POST['numero_boletin']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($numero === '' || $fecha === '') throw new Exception('El número de boletín y la fecha son obligatorios.');

        $fotoNueva = subir_imagen('foto_portada', 'boletines');
        $foto = $fotoNueva ?: $boletin['foto_portada'];
        if ($fotoNueva) borrar_archivo('boletines', $boletin['foto_portada']);

        $pdfNuevo = subir_pdf('archivo_pdf', 'boletines');
        $pdfArchivo = $pdfNuevo ?: $boletin['archivo_pdf'];
        if ($pdfNuevo) borrar_archivo('boletines', $boletin['archivo_pdf']);

        $stmt = $pdo->prepare(
            "UPDATE boletines SET numero_boletin=?, resumen=?, foto_portada=?, archivo_pdf=?, fecha_publicacion=? WHERE id=?"
        );
        $stmt->execute([$numero, trim($_POST['resumen']), $foto, $pdfArchivo, $fecha, $id]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (PDOException $e) {
        $error = (strpos($e->getMessage(), 'uq_boletines_numero') !== false)
            ? 'Ya existe un boletín con ese número.' : $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
$tituloPagina = 'Editar boletín';
$seccionActiva = 'boletines';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Editar</strong> boletín NTEP</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">N° de boletín</label>
                <input type="text" name="numero_boletin" class="form-control" required value="<?= h($boletin['numero_boletin']) ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Fecha de publicación</label>
                <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($boletin['fecha_publicacion']) ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Resumen</label>
            <textarea name="resumen" class="form-control" rows="3"><?= h($boletin['resumen']) ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Imagen de portada</label>
                <?php if ($boletin['foto_portada']): ?><div class="mb-2"><img src="<?= BASE_URL ?>/uploads/boletines/<?= h($boletin['foto_portada']) ?>" width="100" class="rounded"></div><?php endif; ?>
                <input type="file" name="foto_portada" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Archivo PDF</label>
                <?php if ($boletin['archivo_pdf']): ?><div class="mb-2"><a href="<?= BASE_URL ?>/uploads/boletines/<?= h($boletin['archivo_pdf']) ?>" target="_blank">Ver PDF actual</a></div><?php endif; ?>
                <input type="file" name="archivo_pdf" class="form-control" accept="application/pdf">
                <div class="form-text">Deja vacío para conservar el archivo actual.</div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
