<?php
require_once __DIR__ . '/functions.php';
$current = basename($_SERVER['PHP_SELF']);
function nav_link(string $file, string $label, string $current): void {
    $cls = $current === $file ? ' class="active"' : '';
    echo "<a href=\"$file\"$cls>" . e($label) . "</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? 'Adidas') ?> – Adidas Store</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container nav">
    <a href="index.php" class="logo">adidas<span>store</span></a>
    <nav class="links">
      <?php
        nav_link('index.php', 'Home', $current);
        nav_link('products.php', 'Products', $current);
        if (is_logged()) {
            echo '<a href="logout.php">Logout (' . e($_SESSION['user_name']) . ')</a>';
        } else {
            nav_link('login.php', 'Login', $current);
            nav_link('register.php', 'Register', $current);
        }
      ?>
    </nav>
    <form class="search" action="products.php" method="get">
      <input type="search" name="q" placeholder="Search products..." value="<?= e($_GET['q'] ?? '') ?>">
    </form>
    <a href="cart.php" class="cart-link" aria-label="Cart">
      Cart <span id="cart-count" class="badge"><?= cart_count() ?></span>
    </a>
  </div>
</header>
<main>
