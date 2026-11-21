<?php
$pageTitle = 'Register';
require_once 'includes/functions.php';
$errors = []; $name = ''; $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) $errors[] = 'Session expired. Reload the page and try again.';
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($name === '' || mb_strlen($name) > 100) $errors[] = 'Enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (!$errors) {
        $st = db()->prepare("SELECT id FROM users WHERE email = ?");
        $st->execute([$email]);
        if ($st->fetch()) {
            $errors[] = 'This email is already registered. Try logging in.';
        } else {
            db()->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)")
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            $_SESSION['user_id']   = db()->lastInsertId();
            $_SESSION['user_name'] = $name;
            redirect('index.php');
        }
    }
}
require 'includes/header.php';
?>
<section class="section">
  <div class="container narrow">
    <h2 class="title">Create account</h2>
    <?php foreach ($errors as $er): ?><div class="alert err"><?= e($er) ?></div><?php endforeach; ?>
    <form method="post" class="form" novalidate>
      <?= csrf_field() ?>
      <label>Name <input type="text" name="name" value="<?= e($name) ?>" required></label>
      <label>Email <input type="email" name="email" value="<?= e($email) ?>" required></label>
      <label>Password <input type="password" name="password" minlength="6" required></label>
      <button class="btn btn-dark" type="submit">Create account</button>
      <p class="muted">Already have an account? <a href="login.php">Log in</a></p>
    </form>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
