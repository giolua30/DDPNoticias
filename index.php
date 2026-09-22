<?php
require_once 'conexion.php';

/* ==========================================================================
   CONTENIDO ESTÁTICO ORIGINAL
   ========================================================================== */

$reportajesEstaticos = [
    [
        'fecha_sort'  => '2026-08-28',
        'fecha_texto' => 'Ago 28, 2026',
        'titulo'      => 'Más de 730 mineros con Reinfo vigente o suspendido participan en las elecciones regionales y municipales',
        'resumen'     => '43 candidatos buscan llegar a gobiernos regionales y 692 postulan a alcaldías y regidurías. El analista Iván Arenas advierte los posibles conflictos de interés y el riesgo de que estas autoridades favorezcan las actividades mineras informales...',
        'imagen'      => 'assets/images/video.jpg',
        'link'        => 'mas-de-730-mineros-con-reinfo-vigente-o-suspendido-participan-en-las-elecciones-regionales-y-municipales.html',
        'destacado'   => true,
        'dinamico'    => false,
    ],
    [
        'fecha_sort'  => '2026-08-18',
        'fecha_texto' => 'Ago 18, 2026',
        'titulo'      => 'Quiruvilca: el pueblo perforado por la minería ilegal',
        'resumen'     => '',
        'imagen'      => 'assets/images/reportaje-18-08-26.jpg',
        'link'        => 'quiruvilca-el-pueblo-perforado-por-la-mineria-ilegal.html',
        'destacado'   => false,
        'dinamico'    => false,
    ],
    [
        'fecha_sort'  => '2026-08-12',
        'fecha_texto' => 'Ago 12, 2026',
        'titulo'      => 'Cómo evitar que el canon del boom minero termine en obras de poco impacto',
        'resumen'     => '',
        'imagen'      => 'assets/images/reportaje-12-08-26.jpg',
        'link'        => 'como-evitar-que-el-canon-del-boom-minero-termine-en-obras-de-poco-impacto.html',
        'destacado'   => false,
        'dinamico'    => false,
    ],
    [
        'fecha_sort'  => '2026-08-05',
        'fecha_texto' => 'Ago 05, 2026',
        'titulo'      => 'Minería ilegal: la brecha sigue abierta a una semana del nuevo gobierno',
        'resumen'     => '',
        'imagen'      => 'assets/images/reportaje-05-08-26.jpg',
        'link'        => 'mineria-ilegal-la-brecha-sigue-abierta-a-una-semana-del-nuevo-gobierno.html',
        'destacado'   => false,
        'dinamico'    => false,
    ],
];

$noticiasEstaticas = [
    [
        'fecha_sort'  => '2025-11-21',
        'fecha_texto' => 'Noviembre 21, 2025',
        'titulo'      => 'Impulsan talento local en Hualgayoc',
        'imagen'      => 'assets/images/nota-facebook-21-11-25.png',
        'link'        => 'https://minart.pe/2025/11/07/gold-fields-y-empresas-locales-apuestan-por-el-talento-hualgayoquino-capacitando-a-pobladores-en-manejo-de-camiones-mineros-en-hualgayoc/',
    ],
    [
        'fecha_sort'  => '2025-11-21',
        'fecha_texto' => 'Noviembre 21, 2025',
        'titulo'      => 'Inauguran moderno colegio en Cerro Azul',
        'imagen'      => 'assets/images/nota-facebook-21-11-25b.png',
        'link'        => 'https://andina.pe/agencia/noticia-canete-inauguran-moderno-local-colegio-construido-inversion-s30-millones-1051936.aspx',
    ],
    [
        'fecha_sort'  => '2025-11-20',
        'fecha_texto' => 'Noviembre 20, 2025',
        'titulo'      => 'Megaproyecto de saneamiento en Juliaca',
        'imagen'      => 'assets/images/nota-facebook-20-11-25.png',
        'link'        => 'https://diarioelnoticiero.com/ministerio-de-vivienda-llego-a-juliaca-para-reafirmar-que-el-proyecto-de-agua-potable-y-alcantarillado-no-se-detiene-2/',
    ],
];

$boletinEstatico = [
    'fecha_sort'    => '2026-08-28',
    'numero'        => '45',
    'fecha_texto'   => '28 agosto',
    'resumen_lineas'=> [
        'Promueven megaproyectos turísticos por S/ 2,400 mllns.',
        'Invertirán S/ 9 millones en zonas rurales de Cusco.',
        'Producción láctea se duplica en Cajamarca.',
    ],
    'pdf'    => 'boletines/boletin-NTEP-edicion-N45-2808.pdf',
    'imagen' => 'assets/images/boletin-ntep-45.png',
];

$podcastsEstaticos = [
    ['texto' => 'Aumentan casos de hackeo de WhatsApp y delitos informáticos en el país.'],
    ['texto' => 'Ministerio Público exige mayor presupuesto para la lucha contra las extorsiones.'],
    ['texto' => 'Vivamus a ligula quam. elit leo blandit sed eu non ipsum dolor, sed dolor amet laoreet.'],
    ['texto' => 'Vivamus a ligula quam. elit leo blandit sed eu non ipsum dolor, sed dolor amet laoreet.'],
];

$especialesEstaticos = [
    [
        'titulo' => 'Por una mineria artesanal segura para todos',
        'imagen' => 'assets/images/team2.jpg',
        'link'   => '#'
    ],
    [
        'titulo' => 'REINFO Días decisivos en el Congreso',
        'imagen' => 'assets/images/team3.jpg',
        'link'   => '#'
    ],
    [
        'titulo' => 'La minería ilegal: un negocio rentable para bandas criminales',
        'imagen' => 'assets/images/team4.jpg',
        'link'   => '#'
    ],
    [
        'titulo' => 'El problema del REINFO y la minería ilegal en 50 segundos',
        'imagen' => 'assets/images/team5.jpg',
        'link'   => '#'
    ],
];

/* ==========================================================================
   CONTENIDO DINÁMICO (Panel de administración)
   ========================================================================== */

$reportajesBD = $pdo->query("SELECT * FROM reportajes ORDER BY fecha_publicacion DESC")->fetchAll();
$noticiasBD   = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC")->fetchAll();
$boletinesBD  = $pdo->query("SELECT * FROM boletines ORDER BY fecha_publicacion DESC")->fetchAll();
$podcastsBD   = $pdo->query("SELECT * FROM podcasts ORDER BY fecha_publicacion DESC")->fetchAll();

try {
    $videosBD = $pdo->query("SELECT * FROM videos ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $videosBD = [];
}

/* ==========================================================================
   MEZCLA: estático + dinámico
   ========================================================================== */

// --- Reportajes ---
$todosReportajes = $reportajesEstaticos;
foreach ($reportajesBD as $r) {
    $todosReportajes[] = [
        'fecha_sort'  => $r['fecha_publicacion'],
        'fecha_texto' => fecha_larga($r['fecha_publicacion']),
        'titulo'      => $r['titulo'],
        'resumen'     => $r['resumen_corto'] ?: resumir($r['desarrollo'], 220),
        'imagen'      => $r['foto_principal'] ? 'uploads/reportajes/' . $r['foto_principal'] : 'assets/images/video.jpg',
        'link'        => 'reportaje.php?id=' . (int) $r['id'],
        'destacado'   => (bool) $r['es_destacado'],
        'dinamico'    => true,
    ];
}
usort($todosReportajes, fn($a, $b) => strcmp($b['fecha_sort'], $a['fecha_sort']));

$candidatosDestacados = array_values(array_filter($todosReportajes, fn($x) => $x['destacado']));
$reportajeHero = $candidatosDestacados[0] ?? $todosReportajes[0] ?? null;

$reportajesGrilla = array_values(array_filter(
    $todosReportajes,
    fn($x) => $x !== $reportajeHero
));

// --- Noticias ---
$todasNoticias = $noticiasEstaticos;
foreach ($noticiasBD as $n) {
    $todasNoticias[] = [
        'fecha_sort'  => $n['fecha_publicacion'],
        'fecha_texto' => fecha_larga($n['fecha_publicacion']),
        'titulo'      => $n['titulo'],
        'imagen'      => $n['foto'] ? 'uploads/noticias/' . $n['foto'] : null,
        'link'        => $n['link_externo'] ?: '#',
    ];
}
usort($todasNoticias, fn($a, $b) => strcmp($b['fecha_sort'], $a['fecha_sort']));

// --- Boletín ---
$todosBoletines = [$boletinEstatico];
foreach ($boletinesBD as $b) {
    $todosBoletines[] = [
        'fecha_sort'     => $b['fecha_publicacion'],
        'numero'         => $b['numero_boletin'],
        'fecha_texto'    => fecha_larga($b['fecha_publicacion']),
        'resumen_lineas' => array_filter(preg_split('/\r\n|\r|\n/', trim($b['resumen'] ?? ''))),
        'pdf'            => 'uploads/boletines/' . $b['archivo_pdf'],
        'imagen'         => $b['foto_portada'] ? 'uploads/boletines/' . $b['foto_portada'] : null,
    ];
}
usort($todosBoletines, fn($a, $b) => strcmp($b['fecha_sort'], $a['fecha_sort']));
$boletinMostrar = $todosBoletines[0];

// --- Podcast ---
$todosPodcasts = $podcastsEstaticos;
foreach ($podcastsBD as $p) {
    $todosPodcasts[] = [
        'texto' => $p['titulo'],
        'link'  => $p['url_embed'],
    ];
}

// --- Especiales / Videos ---
$todosEspeciales = [];

if (!empty($videosBD)) {
    foreach ($videosBD as $v) {
        $tit = !empty($v['titulo']) ? $v['titulo'] : 'Video sin título';
        $url = !empty($v['url_embed']) ? $v['url_embed'] : '';

        if (preg_match('/src=["\']([^"\']+)["\']/', $url, $mSrc)) {
            $url = $mSrc[1];
        }

        $idYt = '';
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $mYt)) {
            $idYt = $mYt[1];
        }

        $img = 'assets/images/team2.jpg';
        if (!empty($v['miniatura']) && file_exists('uploads/videos/' . $v['miniatura'])) {
            $img = 'uploads/videos/' . $v['miniatura'];
        } elseif (!empty($idYt)) {
            $img = 'https://img.youtube.com/vi/' . $idYt . '/hqdefault.jpg';
        }

        $todosEspeciales[] = [
            'titulo' => $tit,
            'imagen' => $img,
            'link'   => !empty($url) ? $url : '#'
        ];
    }
}

// Unir con estáticos si no hay videos en BD
$todosEspeciales = array_merge($todosEspeciales, $especialesEstaticos);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DDP Noticias - Diálogo y Desarrollo Perú</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
  </head>
  <body>

<header id="site-header" class="fixed-top">
  <div class="container">
      <nav class="navbar navbar-expand-lg stroke">
      <a class="navbar-brand" href="index.php">
          <img src="assets/images/logo.png" alt="Your logo" title="Your logo" style="height:75px;" />
      </a>
          <button class="navbar-toggler collapsed bg-gradient" type="button" data-toggle="collapse"
              data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
              <span class="navbar-toggler-icon fa icon-close fa-times"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item active"><a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a></li>
                  <li class="nav-item"><a class="nav-link" href="#actualidad">Actualidad</a></li>
                  <li class="nav-item"><a class="nav-link" href="reportajes.php">Reportajes</a></li>
                  <li class="nav-item"><a class="nav-link" href="about.html">Podcast</a></li>
                  <li class="nav-item"><a class="nav-link" href="boletines.php">Boletín NTEP</a></li>
                  <li class="nav-item"><a class="nav-link" href="about.html">Alianzas</a></li>
                  <li class="nav-item"><a class="nav-link" href="contact.html">Sobre D&D</a></li>
                  <li class="ml-2"><a href="#footer" class="btn btn-style btn-outline-secondary">Contacto</a></li>
              </ul>
          </div>
      </nav>
  </div>
</header>

<section class="breadcrumb-area py-sm-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Reportajes</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($reportajeHero): ?>
<section class="w3l-video w3l-homeblock3 " id="video">
    <div class="container-fluid">
        <div class="video-grids-info row">
            <div class="video-gd-right col-lg-6 p-0">
                <div class="position-relative">
                    <a href="<?php echo htmlspecialchars($reportajeHero['link'], ENT_QUOTES, 'UTF-8'); ?>">
                        <img src="<?php echo htmlspecialchars($reportajeHero['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="video-gd-left col-lg-6 p-lg-5 p-4 align-self">
                <div class="p-xl-4 p-0 video-wrap">
                    <h5><?php echo htmlspecialchars($reportajeHero['fecha_texto'], ENT_QUOTES, 'UTF-8'); ?></h5>
                    <h3 class="title-big text-left mb-4"><a href="<?php echo htmlspecialchars($reportajeHero['link'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($reportajeHero['titulo'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                    <p><?php echo htmlspecialchars($reportajeHero['resumen'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="<?php echo htmlspecialchars($reportajeHero['link'], ENT_QUOTES, 'UTF-8'); ?>" class="btn mt-4 p-0">Leer <span class="fa fa-arrow-right"></span> </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<div class="grids-block-5 py-1">
    <section class="py-lg-4 py-md-3">
        <div class="container">
            <div class="row">
                <?php foreach ($reportajesGrilla as $r): ?>
                <div class="col-lg-4 col-md-6 grids5-info mt-5">
                    <a href="<?php echo htmlspecialchars($r['link'], ENT_QUOTES, 'UTF-8'); ?>" class="d-block"><img src="<?php echo htmlspecialchars($r['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="img-fluid" /></a>
                    <div class="blog-info">
                        <h5><?php echo htmlspecialchars($r['fecha_texto'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <h4><a href="<?php echo htmlspecialchars($r['link'], ENT_QUOTES, 'UTF-8'); ?>" class="d-block"><?php echo htmlspecialchars($r['titulo'], ENT_QUOTES, 'UTF-8'); ?></a></h4>
                        <a href="<?php echo htmlspecialchars($r['link'], ENT_QUOTES, 'UTF-8'); ?>" class="btn mt-4 p-0">Leer <span class="fa fa-arrow-right"></span> </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <ul><li><a href="reportajes.php">Ver todos</a></li></ul>
            </div>
        </div>
    </section>
</div>

<section class="breadcrumb-area py-sm-5 py-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-contents">
                    <h2 class="title-big">Noticias Recientes</h2><a class="anchor" id="actualidad"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="grids-block-5 py-5">
    <section class="py-lg-4 py-md-3">
        <div class="container">
            <div class="row">
                <?php foreach ($todasNoticias as $n): ?>
                <div class="col-lg-4 col-md-6 grids5-info mt-5">
                    <a target="_blank" href="<?php echo htmlspecialchars($n['link'], ENT_QUOTES, 'UTF-8'); ?>" class="d-block">
                        <?php if ($n['imagen']): ?><img src="<?php echo htmlspecialchars($n['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="img-fluid" /><?php endif; ?>
                    </a>
                    <div class="blog-info">
                        <h5><?php echo htmlspecialchars($n['fecha_texto'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <h4><a target="_blank" href="<?php echo htmlspecialchars($n['link'], ENT_QUOTES, 'UTF-8'); ?>" class="d-block"><?php echo htmlspecialchars($n['titulo'], ENT_QUOTES, 'UTF-8'); ?></a></h4>
                        <a target="_blank" href="<?php echo htmlspecialchars($n['link'], ENT_QUOTES, 'UTF-8'); ?>" class="btn mt-4 p-0">Leer <span class="fa fa-arrow-right"></span> </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination">
                <ul><li><a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru">Ver todos</a></li></ul>
            </div>
        </div>
    </section>
</div>

<section class="w3l-homeblock5 py-0">
    <div class="container py-lg-5 py-4">
        <div class="row">
            <div class="col-lg-8 align-self">
                <h3 class="title-big mb-4">Boletin NTEP Año <?= date('Y', strtotime($boletinMostrar['fecha_sort'])) ?></h3>
                <?php foreach ($boletinMostrar['resumen_lineas'] as $linea): ?>
                    <p>-<?php echo htmlspecialchars($linea, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
                <div class="row mt-sm-4 mt-2 px-3">
                    <div class="col-6 p-0">
                        <span>Nº <?php echo htmlspecialchars($boletinMostrar['numero'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <h4><?php echo htmlspecialchars($boletinMostrar['fecha_texto'], ENT_QUOTES, 'UTF-8'); ?></h4>
                    </div>
                    <div class="col-6 p-0">
                        <span><a target="_blank" href="<?php echo htmlspecialchars($boletinMostrar['pdf'], ENT_QUOTES, 'UTF-8'); ?>" class="facebook"><span class="fa fa-download"></span></a></span>
                        <h4>Ver Boletin</h4>
                    </div>
                    <center><a href="boletines.php" class="btn btn-style btn-primary mt-md-5 mt-4">Ver todos</a></center>
                </div>
            </div>
            <div class="col-lg-4 mt-lg-0 mt-4">
                <?php if ($boletinMostrar['imagen']): ?>
                    <img src="<?php echo htmlspecialchars($boletinMostrar['imagen'], ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid radius-image" alt="">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="w3l-homeblock3 py-5">
    <div class="container py-lg-5 py-md-4">
        <h3 class="title-big mb-5 text-center">Podcast</h3>
        <div class="row">
            <?php foreach ($todosPodcasts as $i => $p): ?>
            <div class="col-lg-3 col-sm-6 <?= $i > 0 ? 'mt-sm-0 mt-5' : '' ?>">
                <?php if (!empty($p['link'])): ?>
                    <a href="<?php echo htmlspecialchars($p['link'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="area-box d-block">
                        <div class="mb-3">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                <line x1="12" y1="19" x2="12" y2="23"></line>
                                <line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                        </div>
                        <p><?php echo htmlspecialchars($p['texto'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                <?php else: ?>
                    <div class="area-box">
                        <img src="assets/images/podcast.png">
                        <p><?php echo htmlspecialchars($p['texto'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <center><a href="#btn" class="btn btn-style btn-primary mt-md-5 mt-4">Ver todos</a></center>
    </div>
</section>

<!-- Especiales / Videos -->
<section class="w3l-team" id="team">
    <div class="teams1 py-5 mb-3">
        <div class="container py-lg-3 pb-lg-5 pb-4">
            <div class="teams1-content">
                <h3 class="title-big text-center mb-5">Especiales</h3>
                
                <div class="owl-carousel owl-theme text-center">
                    <?php foreach ($todosEspeciales as $esp): ?>
                        <div class="item">
                            <div class="d-grid team-info">
                                <div class="column position-relative">
                                    <a href="<?php echo htmlspecialchars($esp['link'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($esp['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="" class="img-fluid rounded team-image" style="height: 200px; object-fit: cover; width: 100%;" />
                                    </a>
                                </div>
                                <div class="column mt-2">
                                    <p><?php echo htmlspecialchars($esp['titulo'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="w3l-banner py-0" id="work">
    <div class="midd-w3 py-lg-4 py-md-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mt-lg-0 mt-lg-5 about-right-faq align-self">
                    <h5 class="title-small mb-2">DDP Noticias</h5>
                    <h3 class="title-banner">Diálogo y Desarrollo Perú</h3>
                    <p class="mt-4">Somos un espacio de periodismo independiente que busca visibilizar las acciones de diálogo en el país desde una mirada constructiva.</p>
                    <a href="#btn" class="btn btn-style btn-primary mt-md-5 mt-4">Nosotros</a>
                 </div>
                <div class="col-md-6 left-wthree-img mt-lg-0 mt-4">
                    <div class="position-relative">
                        <img src="assets/images/bannerimg.png" alt="" class="img-fluid">
                        <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                            <iframe src="https://www.youtube.com/embed/2jI6fHBtRJU" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="middle py-5">
    <div class="container py-xl-5 py-lg-3">
        <div class="welcome-left text-center py-md-5 py-3">
            <h3 class="title-big">Síguenos en nuestras Redes Sociales</h3>
            <div class="main-social-footer-29">
                <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru">
                    <img src="assets/images/facebook.png" alt="Facebook" style="width: 25px !important; height: 25px !important; max-width: 25px !important; display: inline-block !important; object-fit: contain; margin: 0 5px;">
                </a>
                <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo">
                    <img src="assets/images/tiktokp.png" alt="TikTok" style="width: 25px !important; height: 25px !important; max-width: 25px !important; display: inline-block !important; object-fit: contain; margin: 0 5px;">
                </a>
                <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/">
                    <img src="assets/images/instagram.png" alt="Instagram" style="width: 25px !important; height: 25px !important; max-width: 25px !important; display: inline-block !important; object-fit: contain; margin: 0 5px;">
                </a>
            </div>
        </div>
    </div>
</div>

<section class="w3l-footer-29-main py-5" id="footer">
  <div class="footer-29 py-md-3">
    <div class="container">
      <div class="row footer-top-29">
        <div class="col-lg-6 col-md-6 footer-list-29 footer-1">
          <h6 class="footer-title-29">Quiénes Somos</h6>
          <p>Somos un espacio de periodismo independiente que busca visibilizar las acciones de diálogo en el país desde una mirada constructiva.</p>
          <div class="main-social-footer-29">
            <a target="_blank" href="https://www.facebook.com/DialogoyDesarrolloPeru" class="facebook"><img src="assets/images/facebook.png" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle;"></a>
            <a target="_blank" href="https://www.tiktok.com/@dialogo.y.desarrollo" class="tiktok"><img src="assets/images/tiktokp.png" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle;"></a>
            <a target="_blank" href="https://www.instagram.com/dialogo.y.desarrollo/" class="instagram"><img src="assets/images/instagram.png" style="width: 16px; height: 16px; object-fit: contain; vertical-align: middle;"></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 footer-list-29 footer-2 mt-md-0 mt-5">
          <ul>
            <h6 class="footer-title-29">Contenido</h6>
            <li><a href="#url">Noticias</a></li>
            <li><a href="#url">Videos</a></li>
            <li><a href="#url">Podcast</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mt-lg-0 mt-5 footer-list-29 footer-3">
          <div class="properties">
            <h6 class="footer-title-29">Contacto</h6>
            <ul><li><a href="mailto:info@dialogoydesarrollo.com.pe">info@dialogoydesarrollo.com.pe</a></li></ul>
          </div>
        </div>
      </div>
      <div class="bottom-copies text-center">
        <p class="copy-footer-29">© <?= date('Y') ?> Diálogo y Desarrollo Perú. All rights reserved | Designed by <a target="_blank" href="https://www.wsperu.info">WebSolutions</a></p>
      </div>
    </div>
  </div>
  <button onclick="topFunction()" id="movetop" title="Go to top"><span class="fa fa-angle-up"></span></button>
  <script>
    window.onscroll = function () { scrollFunction() };
    function scrollFunction() {
      document.getElementById("movetop").style.display = (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? "block" : "none";
    }
    function topFunction() { document.body.scrollTop = 0; document.documentElement.scrollTop = 0; }
  </script>
</section>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/theme-change.js"></script>
<script src="assets/js/easyResponsiveTabs.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script>
  $(document).ready(function () {
    $('.owl-carousel').owlCarousel({
      loop: true, margin: 0, responsiveClass: true,
      responsive: {
        0: { items: 1, nav: true },
        400: { items: 2, nav: true, margin: 20 },
        768: { items: 3, nav: true, margin: 20 },
        1000: { items: 4, nav: true, loop: true, margin: 25 }
      }
    });
  });
</script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script>
  $(document).ready(function () {
    $('.popup-with-zoom-anim').magnificPopup({ type: 'inline', fixedContentPos: false, fixedBgPos: true, overflowY: 'auto', closeBtnInside: true, preloader: false, midClick: true, removalDelay: 300, mainClass: 'my-mfp-zoom-in' });
  });
</script>
<script>
  $(function () {
    $('.navbar-toggler').click(function () { $('body').toggleClass('noscroll'); });
    $(window).on("scroll", function () {
      $("#site-header").toggleClass("nav-fixed", $(window).scrollTop() >= 80);
    });
  });
</script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>