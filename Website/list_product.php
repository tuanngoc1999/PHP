<?php
require_once("./entities/product.class.php");
require_once("./entities/category.class.php");
?>

<?php
$content = "";
$minPrice = 100000;
$maxPrice = 100000000;
if (isset($_GET["cateid"])) {
  $category = Category::GetCategory($_GET["cateid"]);
  $prod = Product::GetProductByCateID($_GET["cateid"]);
} else if (isset($_GET["list_result"])) {
  $prod = Product::GetProductByName($_GET['result']);
} else if (isset($_GET['notfound'])){
  $prod = Product::GetRandomProduct();
} else {
  $prod = Product::GetProduct();
}

if (isset($_POST["btnSortFromPrice"])) {
  if (isset($_POST["minPrice"]) && isset($_POST['maxPrice'])) {
    if (isset($_GET['cateid'])) {
      // Lọc theo danh mục
      $prod = Product::GetProductByPriceWithCateID($_GET["cateid"], $_POST['minPrice'], $_POST['maxPrice']);
      $content = "( " . number_format($_POST['minPrice']) . " - " . number_format($_POST['maxPrice']) . " VND )";
    } else if (isset($_GET["result"])) {
      $prod = Product::GetProductByPriceWithNameSearch($_GET['result'], $_POST['minPrice'], $_POST['maxPrice']);
      $content = "( " . number_format($_POST['minPrice']) . " - " . number_format($_POST['maxPrice']) . " VND )";
    }
    else {
      // Lọc tất cả sản phẩm
      $prod = Product::GetProductByPrice($_POST['minPrice'], $_POST['maxPrice']);
      $content = "( " . number_format($_POST['minPrice']) . " - " . number_format($_POST['maxPrice']) . " VND )";
    }
  } else {
    header("Location:list_product.php");
  }
}

?>

<?php include_once("header.php"); ?>

<div class="container-fluid" id="list_product">
  <div class="row text-center">
    <!-- Cột danh mục -->
    <div class="col-sm-3">
      <!-- <div style="background-color: #BABABA; height: 50px;"><h4 style="padding-top:2%;">Danh mục</h4></div> -->
      <div class="modal-header" style="text-align: center;">
        <!-- <h3 style="width: 100%;">DANH MỤC</h3> -->
      </br></br>
      </div>
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Mức giá</h5>
          </div>
          <div class="modal-body" style="margin-top: -5%;">
            <div slider id="slider-distance">
              <div>
                <div inverse-left style="width:0%;"></div>
                <div inverse-right style="width:0%;"></div>
                <div range style="left:0%;right:0%;"></div>
                <span thumb style="left:0%;"></span>
                <span thumb style="left:100%;"></span>
                <div sign style="left:0%;">
                  <span id="value">0</span>
                </div>
                <div sign style="left:100%;">
                  <span id="value">100000000</span>
                </div>
              </div>
              <input id="minRange" name="minPrice" type="range" tabindex="0" value="<?= $minPrice ?>" max="100000000" min="100000" step="100000" oninput="
                            this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
                            var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                            var children = this.parentNode.childNodes[1].childNodes;
                            children[1].style.width=value+'%';
                            children[5].style.left=value+'%';
                            children[7].style.left=value+'%';children[11].style.left=value+'%';
                            children[11].childNodes[1].innerHTML=this.value;
                            var slider = document.getElementById('minRange');
                            var outputMax = document.getElementById('outputMin');
                            var num = this.value;
                            outputMax.innerHTML = numberWithCommas(num);                            
                            " />

              <input id="maxRange" name="maxPrice" type="range" tabindex="0" value="<?= $maxPrice ?>" max="100000000" min="100000" step="100000" oninput="
                            this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
                            var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                            var children = this.parentNode.childNodes[1].childNodes;
                            children[3].style.width=(100-value)+'%';
                            children[5].style.right=(100-value)+'%';
                            children[9].style.left=value+'%';children[13].style.left=value+'%';
                            children[13].childNodes[1].innerHTML=this.value;
                            var slider = document.getElementById('maxRange');
                            var outputMax = document.getElementById('outputMax');
                            var num = this.value;
                            outputMax.innerHTML = numberWithCommas(num);" />
            </div>
            <h6>Giá: <span id="outputMin"><?= $minPrice ?></span> -- <span id="outputMax">100000000 VND</span></h6>
            <button class="btn btn-primary" name="btnSortFromPrice" style="width: 100px;" type="submit">Lọc</button>
          </div>
          <div class="modal-header">
            <h5>Danh mục sản phẩm</h5>
          </div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=1'" style="padding-left: 10%; font-weight: 550;">Máy tính</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=2'" style="padding-left: 10%; font-weight: 550;">Laptop</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=3'" style="padding-left: 10%; font-weight: 550;">Chuột</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=4'" style="padding-left: 10%; font-weight: 550;">Bàn phím</div>
        </div>
      </form>
    </div>
    <!-- Cột danh sách sản phẩm -->
    <div class="container col-sm-9">
      <!-- <?php include_once("quangcao.php") ?> -->
      <div style="padding-top: 100px;">
        <h2><?php if (isset($_GET["cateid"])) {
              echo $category[0]["CategoryName"] . $content;
            } else if (isset($_GET["result"])) {
              echo "Kết quả của \"" . $_GET['result'] . "\"" . $content;
            } else if (isset($_GET['notfound'])) {
              echo "Không tìm thấy kết quả cho \"".$_GET['notfound']."\"</br>Có thể bạn sẽ hứng thú";
            } else {
              echo "DANH SÁCH SẢN PHẨM " . $content;
            } ?></h2>
      </div>
      <div style="padding-left:10%;">
        <div class="row justify-content-start" style="margin: auto">
          <?php foreach ($prod as $item) { ?>
            <div class='col-3 place-to-hover' style='margin:30px;'>
              <div style='width: 250px; height: 250px; margin: auto;'>
                <img src='./Image/<?php echo $item["Picture"]; ?>' class='img-responsive' style='width:100%;margin: auto;' alt='Image'>
              </div>
              <span class="btnDetail"><button class="btn btn-primary detail" data-toggle="tooltip" onclick="location.href='product_detail.php?prod_id=<?php echo $item['ProductID'] ?>'" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
              <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php if (isset($_SESSION['user_id']) != ''){echo $_SESSION['user_id'];} ?>&prod_id=<?php echo $item['ProductID'] ?>&quantity=1&price=<?php echo $item['Price'] ?>&btnAddToCart'" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
              <h5 class="txtProductName" onclick="location.href='product_detail.php?prod_id=<?php echo $item['ProductID']; ?>'"><?php echo $item["ProductName"]; ?></h5>
              <h6><?php $p = number_format($item["Price"]);
                  echo $p; ?> VND</h6>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("footer.php"); ?>

<style>
  h5.txtProductName:hover {
    cursor: pointer;
  }

  .modal-body.danhmuc:hover {
    cursor: pointer;
  }

  .col-3.place-to-hover:hover img {
    filter: grayscale(100%);
    -webkit-filter: grayscale(100%);
    transition: filter 0.45s ease-in-out;
  }

  .col-3.place-to-hover span {
    display: none;
    position: absolute;
    top: 185px;

  }

  .col-3.place-to-hover span.btnGioHang {
    left: 105px;
  }

  .col-3.place-to-hover span.btnDetail {
    left: 165px;
  }

  .col-3.place-to-hover:hover span {
    display: block;
  }

  button.detail {
    width: 45px;
    height: 45px;
  }

  #list_product {
    /* background-color: green; */
    padding-top: 2%;
  }

  [slider] {
    position: relative;
    height: 14px;
    border-radius: 10px;
    text-align: left;
    margin: 45px 0 10px 0;
  }

  [slider]>div {
    position: absolute;
    left: 13px;
    right: 15px;
    height: 14px;
  }

  [slider]>div>[inverse-left] {
    position: absolute;
    left: 0;
    height: 14px;
    border-radius: 10px;
    background-color: #CCC;
    margin: 0 7px;
  }

  [slider]>div>[inverse-right] {
    position: absolute;
    right: 0;
    height: 14px;
    border-radius: 10px;
    background-color: #CCC;
    margin: 0 7px;
  }

  [slider]>div>[range] {
    position: absolute;
    left: 0;
    height: 14px;
    border-radius: 14px;
    background-color: #1ABC9C;
  }

  [slider]>div>[thumb] {
    position: absolute;
    top: -7px;
    z-index: 2;
    height: 28px;
    width: 28px;
    text-align: left;
    margin-left: -11px;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
    background-color: #FFF;
    border-radius: 50%;
    outline: none;
  }

  [slider]>input[type=range] {
    position: absolute;
    pointer-events: none;
    -webkit-appearance: none;
    z-index: 3;
    height: 14px;
    top: -2px;
    width: 100%;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    -moz-opacity: 0;
    -khtml-opacity: 0;
    opacity: 0;
  }

  div[slider]>input[type=range]::-ms-track {
    -webkit-appearance: none;
    background: transparent;
    color: transparent;
  }

  div[slider]>input[type=range]::-moz-range-track {
    -moz-appearance: none;
    background: transparent;
    color: transparent;
  }

  div[slider]>input[type=range]:focus::-webkit-slider-runnable-track {
    background: transparent;
    border: transparent;
  }

  div[slider]>input[type=range]:focus {
    outline: none;
  }

  div[slider]>input[type=range]::-ms-thumb {
    pointer-events: all;
    width: 28px;
    height: 28px;
    border-radius: 0px;
    border: 0 none;
    background: red;
  }

  div[slider]>input[type=range]::-moz-range-thumb {
    pointer-events: all;
    width: 28px;
    height: 28px;
    border-radius: 0px;
    border: 0 none;
    background: red;
  }

  div[slider]>input[type=range]::-webkit-slider-thumb {
    pointer-events: all;
    width: 28px;
    height: 28px;
    border-radius: 0px;
    border: 0 none;
    background: red;
    -webkit-appearance: none;
  }

  div[slider]>input[type=range]::-ms-fill-lower {
    background: transparent;
    border: 0 none;
  }

  div[slider]>input[type=range]::-ms-fill-upper {
    background: transparent;
    border: 0 none;
  }

  div[slider]>input[type=range]::-ms-tooltip {
    display: none;
  }

  [slider]>div>[sign] {
    opacity: 0;
    position: absolute;
    margin-left: -11px;
    top: -39px;
    z-index: 3;
    background-color: #1ABC9C;
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 28px;
    -webkit-border-radius: 28px;
    align-items: center;
    -webkit-justify-content: center;
    justify-content: center;
    text-align: center;
  }

  [slider]>div>[sign]:after {
    position: absolute;
    content: '';
    left: 0;
    border-radius: 16px;
    top: 19px;
    border-left: 14px solid transparent;
    border-right: 14px solid transparent;
    border-top-width: 16px;
    border-top-style: solid;
    border-top-color: #1ABC9C;
  }

  [slider]>div>[sign]>span {
    font-size: 12px;
    font-weight: 700;
    line-height: 28px;
  }
</style>
<script>
  function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
  }

  $(document).ready(function() {
    $("#outputMin").each(function() {
      var num = $(this).text();
      var commaNum = numberWithCommas(num);
      $(this).text(commaNum);
    });
  });

  $(document).ready(function() {
    $("#outputMax").each(function() {
      var num = $(this).text();
      var commaNum = numberWithCommas(num);
      $(this).text(commaNum);
    });
  });
</script>