<?php require_once("./config/db.class.php") ?>
<?php 
require_once("./entities/order.class.php");

if (isset($_GET['order_id']) && isset($_GET['prod_id'])) {
  $order = new Order('','','');
  $remove = $order->DeleteFromOrder($_GET['prod_id'], $_GET['order_id']);
  if ($remove){
    header("Location:shopping_cart.php");
  } else {
    echo "<script>alert('Có lỗi xảy ra');</script>";
    echo "<script>location.href='shopping_cart.php';</script>";    
  }
} else {
  echo "<script>alert('Có lỗi xảy ra');</script>";
  echo "<script>location.href='shopping_cart.php';</script>";
}

?>