<?php
require_once __DIR__ . '/../auth.php';

$id = (int) ($_GET['id'] ?? 0);

try {
    $pdo->prepare("DELETE FROM autores WHERE id = ?")->execute([$id]);
    header('Location: listar.php?ok=1');
} catch (PDOException $e) {
    // Error 1451: hay reportajes que usan este autor (FK RESTRICT)
    header('Location: listar.php?error=1');
}
exit;
