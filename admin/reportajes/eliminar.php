<?php
require_once __DIR__ . '/../auth.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT foto_principal, pdf_adjunto FROM reportajes WHERE id = ?");
$stmt->execute([$id]);
$reportaje = $stmt->fetch();

if ($reportaje) {
    $pdo->prepare("DELETE FROM reportajes WHERE id = ?")->execute([$id]);
    borrar_archivo('reportajes', $reportaje['foto_principal']);
    borrar_archivo('reportajes', $reportaje['pdf_adjunto']);
}

header('Location: listar.php?ok=1');
exit;
