<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$boletines = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC")->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Boletín NTEP - DDP Noticias</title>
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
                  <li class="nav-item active"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
              </ul>
          </div>
      </nav>
  </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container"><div class="breadcrumb-contents"><h2 class="title-big">Boletín NTEP</h2></div></div>
</section>

<div class="grids-block-5 py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($boletines as $b): ?>
            <div class="col-lg-4 col-md-6 grids5-info mt-5">
                <?php if ($b['foto_portada']): ?>
                    <img src="uploads/boletines/<?= h($b['foto_portada']) ?>" alt="" class="img-fluid" />
                <?php endif; ?>
                <div class="blog-info">
                    <h5>N° <?= h($b['numero_boletin']) ?> &middot; <?= h(fecha_larga($b['fecha_publicacion'])) ?></h5>
                    <h4><?= h(resumir($b['resumen'], 80)) ?></h4>
                    <a href="uploads/boletines/<?= h($b['archivo_pdf']) ?>" target="_blank" class="btn mt-4 p-0">
                        Ver Boletin <span class="fa fa-download"></span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (!$boletines): ?><div class="col-12 text-center text-muted py-5">No hay boletines publicados todavía.</div><?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer_publico.php'; ?>
