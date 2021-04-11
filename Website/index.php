<?php
// session_start();
if (isset($_SESSION['admin']) != '') {
  session_destroy();
  unset($_SESSION['admin']);
}
?>

<?php require_once("./entities/product.class.php"); ?>
<?php
include_once("header.php");
include_once("quangcao.php");
?>

<?php

$popularProd = Product::GetPopularProduct();
$maytinh = Product::GetProductByCateID(1);
$laptop = Product::GetProductByCateID(2);
$chuot = Product::GetProductByCateID(3);
$banphim = Product::GetProductByCateID(4);

// if (isset($_POST['btnAddToCart'])) {
//   if (isset($_SESSION['user']) == '') {
//     echo "<script>alert('Đăng nhập để thực hiện mua hàng')</script>";
//     echo "<script>$('#frm_dangnhap').modal('toggle');</script>";
//   } else {
//     $uid = $_SESSION['user_id'];
//     $prod_id = 0;
//     header("Location:add_to_cart.php?uid=$uid&prod_id=$prod_id");

//   }
// }

if (isset($_SESSION['user']) != "") {
  $uid = $_SESSION["user_id"];
  echo $_SESSION["user_id"];
} else {
  $uid = 0;
}

if (isset($_GET['request_input'])){
  echo "<script>$('#frm_dangnhap').modal('toggle');</script>";
}
if (isset($_GET['regis_success'])){
  echo "<script>alert('Đăng ký thành công\\nXin hãy đăng nhập lại');</script>";
  echo "<script>$('#frm_dangnhap').modal('toggle');</script>";
}
?>


<form method="POST">
  <div class="container-fluid text-center">
    <!-- Sản phẩm nổi bật -->
    <div class="container" style="padding-top: 1%;">
      <h1>Sản phẩm nổi bật</h1>
    </div>
    <div class="container">
      <div class="owl-carousel owl-theme container-fluid" style="width: 100%;">
        <?php for ($i = 0; $i < 2; $i += 1) { ?>
          <div class="place-to-hover">
              <div style="width:245px;">
                <img src='./Image/<?php echo $popularProd[$i]['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
              </div>
              <span class="btnDetail" ><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $popularProd[$i]['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php echo $uid; ?>&prod_id=<?php echo $popularProd[$i]['ProductID'] ?>&quantity=1&price=<?php echo $popularProd[$i]['Price'] ?>&btnAddToCart'" type="button" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $popularProd[$i]['ProductID'] ?>'"><?php echo $popularProd[$i]["ProductName"]; ?></h6>
              <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($popularProd[$i]["Price"]); ?> VND</h6>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- SẢN PHẨM MÁY TÍNH -->
  <div class="container-fluid text-center">
    <div class="container" style="padding-top: 1%;">
      <h1>Máy tính</h1>
    </div>
    <div class="container">
      <div class="owl-carousel owl-theme container-fluid" style="width: 100%;">
        <?php for ($i = 0; $i < count($maytinh); $i += 1) { ?>
          <div class="place-to-hover">
              <div style="width:245px;">
                <img src='./Image/<?php echo $maytinh[$i]['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
              </div>
              <span class="btnDetail" ><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $maytinh[$i]['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button onclick="location.href='add_to_cart.php?uid=<?php echo $uid; ?>&prod_id=<?php echo $maytinh[$i]['ProductID'] ?>&quantity=1&price=<?php echo $maytinh[$i]['Price'] ?>&btnAddToCart'" name="btnAddToCart" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $maytinh[$i]['ProductID'] ?>'"><?php echo $maytinh[$i]["ProductName"]; ?></h6>
              <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($maytinh[$i]["Price"]); ?> VND</h6>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- SẢN PHẨM LATOP -->
  <div class="container-fluid text-center">
    <div class="container" style="padding-top: 1%;">
      <h1>Chuột</h1>
    </div>
    <div class="container">
      <div class="owl-carousel owl-theme container-fluid" style="width: 100%;">
        <?php for ($i = 0; $i < count($banphim); $i += 1) { ?>
          <div class="place-to-hover">
              <div style="width:245px;">
                <img src='./Image/<?php echo $banphim[$i]['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
              </div>
              <span class="btnDetail" ><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $banphim[$i]['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php echo $uid; ?>&prod_id=<?php echo $banphim[$i]['ProductID'] ?>&quantity=1&price=<?php echo $banphim[$i]['Price'] ?>&btnAddToCart'" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $banphim[$i]['ProductID'] ?>'"><?php echo $banphim[$i]["ProductName"]; ?></h6>
              <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($banphim[$i]["Price"]); ?> VND</h6>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- SẢN PHẨM BÀN PHÍM -->
  <div class="container-fluid text-center">
    <div class="container" style="padding-top: 1%;">
      <h1>Bàn phím</h1>
    </div>
    <div class="container">
      <div class="owl-carousel owl-theme container-fluid" style="width: 100%;">
        <?php for ($i = 0; $i < count($chuot); $i += 1) { ?>
          <div class="place-to-hover">
              <div style="width:245px;">
                <img src='./Image/<?php echo $chuot[$i]['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
              </div>
              <span class="btnDetail" ><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $chuot[$i]['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php echo $uid; ?>&prod_id=<?php echo $chuot[$i]['ProductID'] ?>&quantity=1&price=<?php echo $chuot[$i]['Price'] ?>&btnAddToCart'" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $chuot[$i]['ProductID'] ?>'"><?php echo $chuot[$i]["ProductName"]; ?></h6>
              <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($chuot[$i]["Price"]); ?> VND</h6>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
   <!-- SẢN PHẨM CHUỘT -->
   <div class="container-fluid text-center">
    <div class="container" style="padding-top: 1%;">
      <h1>Laptop</h1>
    </div>
    <div class="container">
      <div class="owl-carousel owl-theme container-fluid" style="width: 100%;">
        <?php for ($i = 0; $i < count($laptop); $i += 1) { ?>
          <div class="place-to-hover">
              <div style="width:245px;">
                <img src='./Image/<?php echo $laptop[$i]['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
              </div>
              <span class="btnDetail" ><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $laptop[$i]['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php echo $uid; ?>&prod_id=<?php echo $laptop[$i]['ProductID'] ?>&quantity=1&price=<?php echo $laptop[$i]['Price'] ?>&btnAddToCart'" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $laptop[$i]['ProductID'] ?>'"><?php echo $laptop[$i]["ProductName"]; ?></h6>
              <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($laptop[$i]["Price"]); ?> VND</h6>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
</form>


<?php include_once("footer.php"); ?>

<style>
  div.owl-item.active{
    text-align: center;
  }
  h6.link_detail {
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
  }

  #btnIconArrow {
    background-color: transparent;
    border: none;
    outline: none;
  }

  #advertisement_panel {
    height: 100px;
  }

  #hot_product {
    width: 100%;
  }

  .place-to-hover:hover img {
    filter: grayscale(100%);
    -webkit-filter: grayscale(100%);
    transition: filter 0.45s ease-in-out;
  }

  .place-to-hover span {
    display: none;
    position: absolute;
    top: 185px;

  }

  .place-to-hover span.btnGioHang {
    left: 133px;
  }

  .place-to-hover span.btnDetail {
    left: 187px;
  }

  .place-to-hover:hover span {
    display: block;
  }

  button.detail {
    width: 45px;
    height: 45px;
  }

  /*  */
</style>

<script>
  $('.owl-carousel').owlCarousel({
    rtl: false,
    loop: false,
    margin: 10,
    nav: true,
    navText: ["<button type='button' class='btn btn-primary'><i class='fas fa-caret-left'></i></button>", "<button type='button' class='btn btn-primary'><i class='fas fa-caret-right'></i></button>"],
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 3
      },
      1000: {
        items: 3
      }
    }
  })
</script>