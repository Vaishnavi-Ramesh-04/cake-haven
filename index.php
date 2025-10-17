<?php
require 'config.php';
$stmt = $pdo->query("SELECT * FROM cakes ORDER BY created_at DESC");
$cakes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cake Haven - Home</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header class="site-header">
  <div class="header-content">
    <h1>Cake Haven</h1>
    <p class="shop-address">📍 123 Sweet Street, Fort Kochi, ERNAKULAM, KERALA
      contact: @cakehaven.com | +91 9876543210
    </p>
  </div>
  <nav>
    <a href="cart.php">Cart (<span id="cart-count">0</span>)</a>
    <a href="admin.php">Admin</a>
  </nav>
</header>



<main class="container">
  <h2>Our Cakes</h2>
  <div class="grid">
  <?php foreach($cakes as $cake): ?>
    <div class="card">
      <img src="<?php echo e($cake['image']); ?>" alt="<?php echo e($cake['name']); ?>">
      <h3><?php echo e($cake['name']); ?></h3>
      <p><?php echo e($cake['description']); ?></p>
      <div class="card-footer">
        <strong>₹<?php echo number_format($cake['price'],2); ?></strong>
  <button class="btn add-to-cart"
                data-id="<?php echo $cake['id']; ?>"
                data-name="<?php echo e($cake['name']); ?>"
                data-price="<?php echo $cake['price']; ?>">Add</button>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</main>
<script src="js/cart.js"></script>
</body>
</html>
