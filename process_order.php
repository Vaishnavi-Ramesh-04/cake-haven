<?php
session_start(); require 'config.php';
$cart=$_SESSION['cart']??[]; if(!$cart){
  if(!empty($_POST)){
    header('Content-Type: application/json'); echo json_encode(['error'=>'Cart empty']); exit;
  }
  header('Location:index.php'); exit; }

$name=$_POST['customer_name']??''; $email=$_POST['customer_email']??'';
$ph=$_POST['customer_phone']??''; $addr=$_POST['delivery_address']??'';
$d=$_POST['delivery_date']??''; $t=$_POST['delivery_time']??'';
$total=0; foreach($cart as $i)$total+=$i['price']*$i['qty'];

$pdo->beginTransaction();
try{
 $stmt = $pdo->prepare("INSERT INTO orders(customer_name,customer_email,customer_phone,delivery_address,delivery_date,delivery_time,total_amount,payment_status)
 VALUES(?,?,?,?,?,?,?,?)");
 // If pay_on_delivery present, set payment_status to 'pending', else mark 'paid' for legacy behavior
 $payOnDelivery = isset($_POST['pay_on_delivery']);
 $payment_status = $payOnDelivery ? 'pending' : 'paid';
 $stmt->execute([$name,$email,$ph,$addr,$d,$t,$total,$payment_status]);
 $oid=$pdo->lastInsertId();
 $q=$pdo->prepare("INSERT INTO order_items(order_id,cake_id,cake_name,unit_price,quantity,subtotal)
                   VALUES(?,?,?,?,?,?)");
 foreach($cart as $i){
   $q->execute([$oid,$i['id'],$i['name'],$i['price'],$i['qty'],$i['price']*$i['qty']]);
 }
 $pdo->commit();
 $_SESSION['cart']=[];
// SMS functionality was removed per request.
 // If AJAX (pay_on_delivery) return JSON
 if($payOnDelivery){ header('Content-Type: application/json'); echo json_encode(['ok'=>1,'orderId'=>$oid]); exit; }
 // Otherwise redirect to confirmation page
 header("Location: order_confirmation.php?id=$oid");
}catch(Exception $e){ $pdo->rollBack();
  if(isset($payOnDelivery)){
    header('Content-Type: application/json'); echo json_encode(['error'=>$e->getMessage()]); exit;
  }
  die($e->getMessage()); }
