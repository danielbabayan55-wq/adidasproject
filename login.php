<?php
$pageTitle = 'Login';
require_once 'includes/functions.php';
$error = ''; $email = '';
$next = $_GET['next'] ?? 'index.php';
if (!preg_match('/^[a-z]+\.php$/', $next)) $next = 'index.php';   // только свои страницы

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if (!csrf_ok()) {
        $error = 'Session expired. Reload the page and try again.';
    } else {
        $st = db()->prepare("SELECT * FROM users WHERE email = ?");
        $st->execute([$email]);
        $u = $st->fetch();
        if ($u && password_verify($pass, $u['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $u['id'];
            $_SESSION['user_name'] = $u['name'];
            redirect($next);
        }
        $error = 'Wrong email or password.';
    }
}
require 'includes/header.php';
?>
<section class="section">
  <div class="container narrow">
    <h2 class="title">Log in</h2>
    <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
      <?= csrf_field() ?>
      <label>Email <input type="email" name="email" value="<?= e($email) ?>" required></label>
      <label>Password <input type="password" name="password" required></label>
      <button class="btn btn-dark" type="submit">Log in</button>
      <p class="muted">No account yet? <a href="register.php">Register</a></p>
    </form>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
