<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT foto_portada, archivo_pdf FROM boletines WHERE id = ?");
$stmt->execute([$id]);
$boletin = $stmt->fetch();
if ($boletin) {
    $pdo->prepare("DELETE FROM boletines WHERE id = ?")->execute([$id]);
    borrar_archivo('boletines', $boletin['foto_portada']);
    borrar_archivo('boletines', $boletin['archivo_pdf']);
}
header('Location: listar.php?ok=1');
exit;
