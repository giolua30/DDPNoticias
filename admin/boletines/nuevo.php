<?php
require_once __DIR__ . '/../auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $numero = trim($_POST['numero_boletin']);
        $fecha  = $_POST['fecha_publicacion'];
        if ($numero === '' || $fecha === '') throw new Exception('El número de boletín y la fecha son obligatorios.');

        $pdfArchivo = subir_pdf('archivo_pdf', 'boletines');
        if (!$pdfArchivo) throw new Exception('Debes adjuntar el PDF del boletín.');
        $foto = subir_imagen('foto_portada', 'boletines');

        $stmt = $pdo->prepare(
            "INSERT INTO boletines (numero_boletin, resumen, foto_portada, archivo_pdf, fecha_publicacion, usuario_id)
             VALUES (?,?,?,?,?,?)"
        );
        $stmt->execute([$numero, trim($_POST['resumen']), $foto, $pdfArchivo, $fecha, $_SESSION['usuario_id']]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (PDOException $e) {
        $error = (strpos($e->getMessage(), 'uq_boletines_numero') !== false)
            ? 'Ya existe un boletín con ese número.' : $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
$tituloPagina = 'Nuevo boletín';
$seccionActiva = 'boletines';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Nuevo</strong> boletín NTEP</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">N° de boletín (ej. 45)</label>
                <input type="text" name="numero_boletin" class="form-control" required value="<?= h($_POST['numero_boletin'] ?? '') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Fecha de publicación</label>
                <input type="date" name="fecha_publicacion" class="form-control" required value="<?= h($_POST['fecha_publicacion'] ?? date('Y-m-d')) ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Resumen (titulares que aparecen en la portada)</label>
            <textarea name="resumen" class="form-control" rows="3" placeholder="-Titular 1&#10;-Titular 2&#10;-Titular 3"><?= h($_POST['resumen'] ?? '') ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Imagen de portada</label>
                <input type="file" name="foto_portada" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Archivo PDF del boletín</label>
                <input type="file" name="archivo_pdf" class="form-control" accept="application/pdf" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
