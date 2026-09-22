<?php
require_once __DIR__ . '/../auth.php';
$id = (int) ($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM videos WHERE id = ?")->execute([$id]);
header('Location: listar.php?ok=1');
exit;
