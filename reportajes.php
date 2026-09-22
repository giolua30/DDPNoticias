<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$porPagina = 9;
$pagina = max(1, (int) ($_GET['pagina'] ?? 1));
$total = (int) $pdo->query("SELECT COUNT(*) FROM reportajes")->fetchColumn();
$totalPaginas = max(1, (int) ceil($total / $porPagina));
$offset = ($pagina - 1) * $porPagina;

$stmt = $pdo->prepare("SELECT * FROM reportajes ORDER BY fecha_publicacion DESC LIMIT :lim OFFSET :off");
$stmt->bindValue(':lim', $porPagina, PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$reportajes = $stmt->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reportajes - DDP Noticias</title>
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
                  <li class="nav-item active"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                  <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
              </ul>
          </div>
      </nav>
  </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container"><div class="breadcrumb-contents"><h2 class="title-big">Todos los Reportajes</h2></div></div>
</section>

<div class="grids-block-5 py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($reportajes as $r): ?>
            <div class="col-lg-4 col-md-6 grids5-info mt-5">
                <a href="reportaje.php?id=<?= (int) $r['id'] ?>" class="d-block">
                    <?php if ($r['foto_principal']): ?>
                        <img src="uploads/reportajes/<?= h($r['foto_principal']) ?>" alt="" class="img-fluid" />
                    <?php else: ?>
                        <img src="assets/images/video.jpg" alt="" class="img-fluid" />
                    <?php endif; ?>
                </a>
                <div class="blog-info">
                    <h5><?= h(fecha_larga($r['fecha_publicacion'])) ?></h5>
                    <h4><a href="reportaje.php?id=<?= (int) $r['id'] ?>" class="d-block"><?= h($r['titulo']) ?></a></h4>
                    <p><?= h(resumir($r['resumen_corto'] ?: $r['desarrollo'], 120)) ?></p>
                    <a href="reportaje.php?id=<?= (int) $r['id'] ?>" class="btn mt-4 p-0">Leer <span class="fa fa-arrow-right"></span></a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (!$reportajes): ?><div class="col-12 text-center text-muted py-5">No hay reportajes publicados.</div><?php endif; ?>
        </div>

        <?php if ($totalPaginas > 1): ?>
        <div class="pagination justify-content-center mt-4">
            <ul>
                <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
                    <li><a href="?pagina=<?= $p ?>" class="<?= $p === $pagina ? 'active' : '' ?>"><?= $p ?></a></li>
                <?php endfor; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer_publico.php'; ?>
