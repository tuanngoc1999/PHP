<?php require_once("./config/db.class.php") ?>
<?php 
require_once("./entities/order.class.php");

if (isset($_GET['prod_id']) && isset($_GET['order_id']) && isset($_GET['quantity'])){
  $order = new Order('','','');
  $change = $order->ChangeValue($_GET['order_id'], $_GET['prod_id'], $_GET['quantity']);

  if ($change){
    echo "<script>location.href = 'shopping_cart.php';</script>";
  } else {
    echo "<script>alert('Có lỗi xảy ra');</script>";
    echo "<script>location.href = 'shopping_cart.php';</script>";  
  }
} else {
  echo "<script>alert('Có lỗi xảy ra');</script>";
  echo "<script>location.href = 'shopping_cart.php';</script>";
}

?>