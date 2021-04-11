<?php require_once("./config/db.class.php") ?>
<?php 
require_once("./entities/order.class.php");

session_start();

if (isset($_GET['btnAddToCart']) && isset($_SESSION['user_id']) == ''){
  header("Location:index.php?request_input&'");
} else {
  if (!isset($_GET['uid']) || $_GET['uid'] <= 0){
    echo "<script>alert('Đăng nhập để thực hiện mua hàng')</script>";
    echo "<script>location.href = 'index.php?request_input';</script>";
  }

  $uid = $_GET['uid'];
  $prod_id = $_GET['prod_id'];
  $quantity = $_GET['quantity'];
  $price = $_GET['price'];

  $cart = new Order($prod_id, $quantity, $price);
  $addToCart = $cart->AddToCart($uid, $prod_id, $quantity, $price); 

  if (!$addToCart){
    var_dump("Failed");die;
    echo "<script>alert('Có lỗi xảy ra');</script>";
    echo "<script>location.reload('index.php');</script>";
  }else if (isset($_GET['list'])){
    echo "<script>location.href='list_product.php?".$_GET['list']."';</script>";
  } 
  else {
    echo "<script>location.href='index.php';</script>";
  }
}

?>