<?php
$pageTitle = 'Home';
require 'includes/header.php';
$latest = db()->query("SELECT * FROM products ORDER BY created_at DESC, id DESC LIMIT 4")->fetchAll();
?>
<section class="hero">
  <div class="container">
    <h1>Impossible is nothing</h1>
    <p>Adidas is a German multinational corporation – the largest in Europe and the second-largest in the world – that manufactures sportswear, footwear, accessories, and equipment.</p>
    <div class="hero-actions">
      <a class="btn btn-light" href="products.php">Browse products</a>
      <a class="btn btn-outline" href="#about">About us</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="title">New products</h2>
    <div class="grid">
      <?php foreach ($latest as $p) render_card($p); ?>
    </div>
  </div>
</section>

<section class="section alt" id="about">
  <div class="container about">
    <h2 class="title">Why shop here</h2>
    <div class="features">
      <div><h3>Free delivery</h3><p>On every order in the city.</p></div>
      <div><h3>Easy returns</h3><p>Changed your mind? Bring it back within 30 days.</p></div>
      <div><h3>Secure account</h3><p>Passwords are hashed and never stored in plain text.</p></div>
    </div>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
