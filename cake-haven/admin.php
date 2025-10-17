<?php
session_start();
require 'config.php';

// Admin credentials are read from config.php ($ADMIN_USER, $ADMIN_PASS_HASH)

// Logout
if(isset($_GET['logout'])){ session_destroy(); header('Location: admin.php'); exit; }

// Handle login
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['username'])){
			if($_POST['username']===$ADMIN_USER && isset($_POST['password']) && password_verify($_POST['password'], $ADMIN_PASS_HASH)){
		$_SESSION['is_admin']=true; header('Location: admin.php'); exit;
	} else {
		$error = 'Invalid credentials';
	}
}

$orders = [];
if(!empty($_SESSION['is_admin'])){
	// fetch orders in ascending order of id
	$orders=$pdo->query("SELECT * FROM orders ORDER BY id ASC")->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Admin</title>
<link rel="stylesheet" href="css/styles.css"></head>
<body>
<header class="site-header"><h1>Admin</h1></header>
<main class="container">
<?php if(empty($_SESSION['is_admin'])): ?>
		<h2>Admin Login</h2>
		<?php if(!empty($error)): ?><p style="color:red"><?php echo e($error); ?></p><?php endif; ?>
		<form method="post" class="admin-login-form">
			<label>Username<input name="username" required></label>
			<label>Password<input type="password" name="password" required></label>
			<div style="margin-top:12px;"><button class="btn" type="submit">Login</button></div>
		</form>
<?php else: ?>
	<p><a class="btn" href="admin.php?logout=1">Logout</a></p>
	<h2>Orders</h2>
		<table class="cart-table">
		<tr><th>ID</th><th>Name</th><th>Date</th><th>Time</th><th>Total</th><th></th></tr>
	<?php foreach($orders as $o): ?>
	<tr>
	<td><?php echo $o['id']; ?></td>
	<td><?php echo e($o['customer_name']); ?></td>
		<td><?php echo e($o['delivery_date']); ?></td>
		<td><?php echo e($o['delivery_time']); ?></td>
		<td>₹<?php echo $o['total_amount']; ?></td>
	<td><a class="btn" href="order_confirmation.php?id=<?php echo $o['id']; ?>">View</a></td>
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</main>
</body>
</html>
