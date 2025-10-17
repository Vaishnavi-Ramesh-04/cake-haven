<?php
require 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM cakes WHERE id=?");
$stmt->execute([$id]);
$cake = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$cake){ header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo e($cake['name']); ?></title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="site-header">
  <h1><a href="index.php">Cake Haven</a></h1>
  <nav><a href="cart.php">Cart</a></nav>
</header>

<main class="container">
  <div class="product">
    <img src="<?php echo e($cake['image']); ?>" alt="<?php echo e($cake['name']); ?>">
    <div class="product-info">
      <h2><?php echo e($cake['name']); ?></h2>
      <p><?php echo e($cake['description']); ?></p>
      <p class="price">₹<?php echo number_format($cake['price'],2); ?></p>
      <label>Qty:
        <input id="qty" type="number" min="1" value="1">
      </label>
      <button class="btn add-to-cart"
              data-id="<?php echo $cake['id']; ?>"
              data-name="<?php echo e($cake['name']); ?>"
              data-price="<?php echo $cake['price']; ?>">Add to Cart</button>
    </div>
  </div>
</main>
<script src="js/cart.js"></script>
</body>
</html>
