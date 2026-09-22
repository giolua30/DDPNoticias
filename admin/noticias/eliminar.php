<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT foto FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();
if ($noticia) {
    $pdo->prepare("DELETE FROM noticias WHERE id = ?")->execute([$id]);
    borrar_archivo('noticias', $noticia['foto']);
}
header('Location: listar.php?ok=1');
exit;
