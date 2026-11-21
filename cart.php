<?php
$pageTitle = 'Cart';
require_once 'includes/functions.php';
$message = ''; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $action = $_POST['action'] ?? '';

    if ($action === 'update') {
        foreach (($_POST['qty'] ?? []) as $id => $qty) {
            $id = (int)$id; $qty = (int)$qty;
            if ($qty <= 0) unset($_SESSION['cart'][$id]);
            else $_SESSION['cart'][$id] = min($qty, 99);
        }
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][(int)($_POST['id'] ?? 0)]);
    } elseif ($action === 'checkout') {
        if (!is_logged()) {
            redirect('login.php?next=cart.php');
        }
        $items = cart_items();
        if ($items) {
            $pdo = db();
            try {
                $pdo->beginTransaction();
                $total = array_sum(array_column($items, 'subtotal'));
                $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)")
                    ->execute([$_SESSION['user_id'], $total]);
                $orderId = $pdo->lastInsertId();
                $ins = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                foreach ($items as $it) $ins->execute([$orderId, $it['id'], $it['qty'], $it['price']]);
                $pdo->commit();
                $_SESSION['cart'] = [];
                $message = "Order #$orderId placed. Thank you!";
            } catch (Exception $ex) {
                $pdo->rollBack();
                $error = 'Could not place the order. Please try again.';
            }
        }
    }
}

require 'includes/header.php';
$items = cart_items();
$total = array_sum(array_column($items, 'subtotal'));
?>
<section class="section">
  <div class="container">
    <h2 class="title">Your cart</h2>
    <?php if ($message): ?><div class="alert ok"><?= e($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>

    <?php if (!$items): ?>
      <p class="empty">Your cart is empty. <a href="products.php">Find something to add</a>.</p>
    <?php else: ?>
      <form method="post" class="cart-form">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update">
        <table class="cart-table">
          <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($items as $it): ?>
            <tr>
              <td class="cell-prod"><img src="<?= product_image($it) ?>" alt=""> <?= e($it['name']) ?></td>
              <td><?= money($it['price']) ?></td>
              <td><input type="number" min="0" max="99" name="qty[<?= (int)$it['id'] ?>]" value="<?= (int)$it['qty'] ?>"></td>
              <td><?= money($it['subtotal']) ?></td>
              <td>
                <button type="submit" form="rm-<?= (int)$it['id'] ?>" class="link-btn">Remove</button>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <div class="cart-actions">
          <button class="btn btn-outline-dark" type="submit">Update quantities</button>
          <div class="total">Total: <strong><?= money($total) ?></strong></div>
        </div>
      </form>

      <?php foreach ($items as $it): ?>
        <form id="rm-<?= (int)$it['id'] ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="remove">
          <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
        </form>
      <?php endforeach; ?>

      <form method="post" class="checkout">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="checkout">
        <button class="btn btn-dark" type="submit"><?= is_logged() ? 'Place order' : 'Log in to place order' ?></button>
      </form>
    <?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
