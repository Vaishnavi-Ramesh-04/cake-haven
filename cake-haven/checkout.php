<?php
session_start(); require 'config.php';
$c=$_SESSION['cart']??[]; if(!$c){ header('Location: cart.php'); exit; }
$total=0; foreach($c as $i)$total+=$i['price']*$i['qty'];
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Checkout</title>
<link rel="stylesheet" href="css/styles.css"></head>
<body>
<header class="site-header"><h1>Cake Haven</h1></header>
<main class="container">
<h2>Checkout</h2>
<form action="process_order.php" method="post">
<label>Name<input name="customer_name" required></label><br>
<label>Email<input type="email" name="customer_email" required></label><br>
<label>Phone<input name="customer_phone" required></label><br>
<label>Address<textarea name="delivery_address" required></textarea></label><br>
<label>Date<input type="date" name="delivery_date" required min="<?php echo date('Y-m-d'); ?>"></label>
<label>Time<input type="time" name="delivery_time" required></label><br>
<p><b>Total ₹<?php echo $total; ?></b></p>
<button class="btn" type="submit">Place Order</button>
</form>
</main>
</body>
</html>
