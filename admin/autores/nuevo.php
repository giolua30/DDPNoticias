<?php
require_once __DIR__ . '/../auth.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombres = trim($_POST['nombres']);
        if ($nombres === '') throw new Exception('El nombre es obligatorio.');

        $stmt = $pdo->prepare(
            "INSERT INTO autores (nombres, ap_paterno, ap_materno, nickname, es_nickname) VALUES (?,?,?,?,?)"
        );
        $stmt->execute([
            $nombres,
            trim($_POST['ap_paterno']) ?: null,
            trim($_POST['ap_materno']) ?: null,
            trim($_POST['nickname']) ?: null,
            isset($_POST['es_nickname']) ? 1 : 0,
        ]);
        header('Location: listar.php?ok=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$tituloPagina = 'Nuevo autor';
$seccionActiva = 'autores';
require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3"><strong>Nuevo</strong> autor</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<div class="card">
    <div class="card-body">
        <form method="post">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nombres</label>
                    <input type="text" name="nombres" class="form-control" required value="<?= h($_POST['nombres'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Apellido paterno</label>
                    <input type="text" name="ap_paterno" class="form-control" value="<?= h($_POST['ap_paterno'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Apellido materno</label>
                    <input type="text" name="ap_materno" class="form-control" value="<?= h($_POST['ap_materno'] ?? '') ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nickname (seudónimo, opcional)</label>
                <input type="text" name="nickname" class="form-control" value="<?= h($_POST['nickname'] ?? '') ?>">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="es_nickname" id="es_nickname">
                <label class="form-check-label" for="es_nickname">Mostrar el nickname en vez del nombre completo</label>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
