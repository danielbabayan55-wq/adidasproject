<?php
require_once __DIR__ . '/../config.php';

// Безопасный вывод текста в HTML (защита от XSS)
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function is_logged(): bool { return isset($_SESSION['user_id']); }

function redirect(string $url): void { header("Location: $url"); exit; }

// CSRF-токен для форм
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}
function csrf_ok(): bool {
    return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

// Корзина хранится в сессии: [product_id => quantity]
function cart_count(): int { return array_sum($_SESSION['cart'] ?? []); }

function cart_items(): array {
    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) return [];
    $ids = array_map('intval', array_keys($cart));
    $in  = implode(',', array_fill(0, count($ids), '?'));
    $st  = db()->prepare("SELECT * FROM products WHERE id IN ($in)");
    $st->execute($ids);
    $items = [];
    foreach ($st->fetchAll() as $p) {
        $p['qty'] = $cart[$p['id']];
        $p['subtotal'] = $p['qty'] * $p['price'];
        $items[] = $p;
    }
    return $items;
}

function money($n): string { return '$' . number_format((float)$n, 2); }

function product_image(array $p): string {
    if (!empty($p['image']) && file_exists(__DIR__ . '/../assets/img/products/' . $p['image'])) {
        return 'assets/img/products/' . e($p['image']);
    }
    return 'assets/img/placeholder.svg';
}

// Карточка товара (используется на главной и в каталоге)
function render_card(array $p): void { ?>
  <article class="card">
    <div class="card-img"><img src="<?= product_image($p) ?>" alt="<?= e($p['name']) ?>" loading="lazy"></div>
    <div class="card-body">
      <span class="card-cat"><?= e($p['category']) ?></span>
      <h3><?= e($p['name']) ?></h3>
      <p><?= e($p['description']) ?></p>
      <div class="card-foot">
        <strong><?= money($p['price']) ?></strong>
        <button class="btn btn-dark add-to-cart" data-id="<?= (int)$p['id'] ?>">Add to cart</button>
      </div>
    </div>
  </article>
<?php }
