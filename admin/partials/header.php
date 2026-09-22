<?php
/**
 * $tituloPagina y $seccionActiva deben estar definidos ANTES de incluir este archivo.
 * $seccionActiva sirve para resaltar el ítem activo del menú lateral.
 */
if (!isset($seccionActiva)) $seccionActiva = '';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= h($tituloPagina ?? 'Panel') ?> - DyD Perú</title>
    <link href="<?= BASE_URL ?>/admin/assets/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="<?= BASE_URL ?>/admin/index.php">
                <span class="align-middle">DyD Perú</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">Panel</li>

                <li class="sidebar-item <?= $seccionActiva === 'dashboard' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/index.php">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-header">Contenido</li>

                <li class="sidebar-item <?= $seccionActiva === 'reportajes' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/reportajes/listar.php">
                        <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Reportajes</span>
                    </a>
                </li>

                <li class="sidebar-item <?= $seccionActiva === 'noticias' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/noticias/listar.php">
                        <i class="align-middle" data-feather="rss"></i> <span class="align-middle">Noticias</span>
                    </a>
                </li>

                <li class="sidebar-item <?= $seccionActiva === 'boletines' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/boletines/listar.php">
                        <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Boletín NTEP</span>
                    </a>
                </li>

                <li class="sidebar-item <?= $seccionActiva === 'podcasts' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/podcasts/listar.php">
                        <i class="align-middle" data-feather="mic"></i> <span class="align-middle">Podcast</span>
                    </a>
                </li>

                <li class="sidebar-item <?= $seccionActiva === 'videos' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/videos/listar.php">
                        <i class="align-middle" data-feather="video"></i> <span class="align-middle">Videos</span>
                    </a>
                </li>

                <li class="sidebar-item <?= $seccionActiva === 'autores' ? 'active' : '' ?>">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/admin/autores/listar.php">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Autores</span>
                    </a>
                </li>

                <li class="sidebar-header">Sitio</li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= BASE_URL ?>/index.php" target="_blank">
                        <i class="align-middle" data-feather="external-link"></i> <span class="align-middle">Ver sitio público</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                            <span class="text-dark"><?= h($_SESSION['usuario_nombre'] ?? '') ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?= BASE_URL ?>/admin/logout.php">
                                <i class="align-middle me-1" data-feather="log-out"></i> Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="content">
            <div class="container-fluid p-0">
