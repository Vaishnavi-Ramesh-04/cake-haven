<?php
session_start();
require 'config.php';
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['action'])){
  header('Content-Type:application/json');
  $a=$_POST['action'];
  if($a=='add'){
    $id=(int)$_POST['id']; $n=$_POST['name']; $p=(float)$_POST['price']; $q=max(1,(int)($_POST['qty']??1));
    if(isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['qty']+=$q;
    else $_SESSION['cart'][$id]=['id'=>$id,'name'=>$n,'price'=>$p,'qty'=>$q];
    echo json_encode(['cartCount'=>array_sum(array_column($_SESSION['cart'],'qty'))]); exit;
  }
  if($a=='update'){ $id=(int)$_POST['id']; $q=max(0,(int)$_POST['qty']); 
    if($q<=0) unset($_SESSION['cart'][$id]); else $_SESSION['cart'][$id]['qty']=$q;
    echo json_encode(['ok'=>1]); exit;
  }
  if($a=='clear'){ $_SESSION['cart']=[]; echo json_encode(['ok'=>1]); exit; }
  if($a=='count'){ echo json_encode(['count'=>array_sum(array_column($_SESSION['cart'],'qty'))]); exit; }
}

$cart=$_SESSION['cart']; $total=0; foreach($cart as $i) $total+=$i['price']*$i['qty'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"><title>Cart</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="site-header"><h1><a href="index.php">Cake Haven</a></h1></header>
<main class="container">
<h2>Your Cart</h2>
<?php if(!$cart): ?><p>Cart is empty.</p>
<?php else: ?>

<table class="cart-table">
  <thead>
    <tr>
      <th>Item</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Subtotal</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($cart as $id => $item): 
      $subtotal = $item['qty'] * $item['price']; ?>
      <tr>
        <td><?php echo e($item['name']); ?></td>
        <td>₹ <?php echo number_format($item['price'], 2); ?></td>
        <td>
          <input class="qty-input" data-id="<?php echo $id; ?>" 
                 type="number" min="1" value="<?php echo $item['qty']; ?>">
        </td>
        <td>₹ <?php echo number_format($subtotal, 2); ?></td>
        <td><button class="btn remove-item" data-id="<?php echo $id; ?>">Remove</button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="cart-summary">
  <strong>Total: ₹ <?php echo number_format($total, 2); ?></strong>
</div>

<?php endif; ?>
</main>
<script src="js/cart.js"></script>
<?php if($cart): ?>
<!-- Confirm Order modal trigger -->
<div class="confirm-actions" style="padding:16px; text-align:right;">
  <button id="confirm-order" class="btn">Confirm Order</button>
</div>
<!-- Modal markup (hidden) -->
<div id="confirm-modal" class="modal" style="display:none;">
  <div class="modal-content">
    <h3>Confirm Order</h3>
    <form id="confirm-form">
      <label>Name<input name="customer_name" required></label>
      <label>Email<input type="email" name="customer_email" required></label>
      <label>Phone<input name="customer_phone" required></label>
      <label>Address<textarea name="delivery_address" required></textarea></label>
      <label>Date<input type="date" name="delivery_date" required min="<?php echo date('Y-m-d'); ?>"></label>
      <label>Time<input type="time" name="delivery_time" required></label>
      <div style="margin-top:10px; text-align:right;">
        <button type="button" id="cancel-confirm" class="btn">Cancel</button>
        <button type="submit" class="btn">Place Order (Pay on delivery)</button>
      </div>
    </form>
  </div>
</div>
<script src="js/confirm_order.js"></script>
<?php endif; ?>
</body>
</html>
