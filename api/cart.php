<?php
// JSON API для корзины: вызывается из JavaScript (fetch)
require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'POST only']); exit;
}

$id = (int)($_POST['id'] ?? 0);
$st = db()->prepare("SELECT id FROM products WHERE id = ?");
$st->execute([$id]);
if (!$st->fetch()) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Product not found']); exit;
}

$_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
echo json_encode(['ok' => true, 'count' => cart_count()]);
