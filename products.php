<?php
$pageTitle = 'Products';
require 'includes/header.php';

$q   = trim($_GET['q'] ?? '');
$cat = trim($_GET['cat'] ?? '');

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];
if ($q !== '')   { $sql .= " AND (name LIKE ? OR description LIKE ?)"; $params[] = "%$q%"; $params[] = "%$q%"; }
if ($cat !== '') { $sql .= " AND category = ?"; $params[] = $cat; }
$sql .= " ORDER BY id DESC";

$st = db()->prepare($sql);
$st->execute($params);
$products = $st->fetchAll();
$cats = db()->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<section class="section">
  <div class="container">
    <h2 class="title">Products</h2>
    <div class="filters">
      <a href="products.php" class="chip <?= $cat === '' ? 'on' : '' ?>">All</a>
      <?php foreach ($cats as $c): ?>
        <a href="products.php?cat=<?= urlencode($c) ?>" class="chip <?= $cat === $c ? 'on' : '' ?>"><?= e($c) ?></a>
      <?php endforeach; ?>
    </div>

    <?php if ($q !== ''): ?><p class="muted">Results for “<?= e($q) ?>”: <?= count($products) ?></p><?php endif; ?>

    <?php if (!$products): ?>
      <p class="empty">Nothing found. Try another search or <a href="products.php">see all products</a>.</p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($products as $p) render_card($p); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
