<?php
require 'config.php';
$id=(int)$_GET['id'];
$o=$pdo->query("SELECT * FROM orders WHERE id=$id")->fetch();
$items=$pdo->query("SELECT * FROM order_items WHERE order_id=$id")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Order Confirmation</title>
<link rel="stylesheet" href="css/styles.css"></head>
<body>
<header class="site-header"><h1>Cake Haven</h1></header>
<main class="container">
<h2>Order #<?php echo $id; ?></h2>
<p><b>Name:</b> <?php echo e($o['customer_name']); ?><br>
<b>Email:</b> <?php echo e($o['customer_email']); ?><br>
<b>Phone:</b> <?php echo e($o['customer_phone']); ?><br>
<b>Address:</b> <?php echo e($o['delivery_address']); ?><br>
<b>Date:</b> <?php echo e($o['delivery_date']); ?> <?php echo e($o['delivery_time']); ?></p>

<table class="cart-table">
<tr><th>Cake</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
<?php foreach($items as $i): ?>
<tr><td><?php echo e($i['cake_name']); ?></td><td><?php echo $i['quantity']; ?></td>
<td>₹<?php echo $i['unit_price']; ?></td><td>₹<?php echo $i['subtotal']; ?></td></tr>
<?php endforeach; ?>
</table>
<h3>Total ₹<?php echo $o['total_amount']; ?></h3>
<a class="btn" href="index.php">Back Home</a>
</main>
</body>
</html>
