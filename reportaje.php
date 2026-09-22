<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare(
    "SELECT r.*, COALESCE(a.nickname, CONCAT(a.nombres,' ',a.ap_paterno)) AS autor
     FROM reportajes r LEFT JOIN autores a ON a.id = r.autor_id
     WHERE r.id = ?"
);
$stmt->execute([$id]);
$reportaje = $stmt->fetch();

if (!$reportaje) {
    header('Location: index.php');
    exit;
}

$fotosStmt = $pdo->prepare("SELECT * FROM reportajes_fotos WHERE reportaje_id = ? ORDER BY orden");
$fotosStmt->execute([$id]);
$fotosExtra = $fotosStmt->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= h($reportaje['titulo']) ?> - DDP Noticias</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>
<body>
<header id="site-header" class="fixed-top">
  <div class="container">
      <nav class="navbar navbar-expand-lg stroke">
      <a class="navbar-brand" href="index.php"><img src="assets/images/logo.png" alt="Logo" style="height:75px;" /></a>
          <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
              <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                  <li class="nav-item"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                  <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
              </ul>
          </div>
      </nav>
  </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="breadcrumb-contents">
            <h2 class="title-big"><?= h($reportaje['titulo']) ?></h2>
            <p class="mt-2">
                <?= h(fecha_larga($reportaje['fecha_publicacion'])) ?>
                <?php if ($reportaje['autor']): ?> &middot; Por <?= h($reportaje['autor']) ?><?php endif; ?>
            </p>
        </div>
    </div>
</section>

<section class="w3l-blog py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <?php if ($reportaje['foto_principal']): ?>
                    <img src="uploads/reportajes/<?= h($reportaje['foto_principal']) ?>" class="img-fluid radius-image mb-4" alt="">
                <?php endif; ?>

                <div class="reportaje-cuerpo">
                    <?php foreach (preg_split('/\r\n|\r|\n/', trim($reportaje['desarrollo'])) as $parrafo): ?>
                        <?php if (trim($parrafo) !== ''): ?><p class="mb-3"><?= h($parrafo) ?></p><?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($fotosExtra): ?>
                    <div class="row mt-4">
                        <?php foreach ($fotosExtra as $f): ?>
                            <div class="col-md-6 mb-3">
                                <img src="uploads/reportajes/<?= h($f['url_foto']) ?>" class="img-fluid radius-image" alt="<?= h($f['descripcion']) ?>">
                                <?php if ($f['descripcion']): ?><p class="text-muted small mt-1"><?= h($f['descripcion']) ?></p><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($reportaje['pdf_adjunto']): ?>
                    <a href="uploads/reportajes/<?= h($reportaje['pdf_adjunto']) ?>" target="_blank" class="btn btn-style btn-primary mt-4">
                        <span class="fa fa-download"></span> Descargar PDF adjunto
                    </a>
                <?php endif; ?>

                <div class="mt-5">
                    <a href="index.php" class="btn btn-style btn-outline-secondary">&larr; Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer_publico.php'; ?>
