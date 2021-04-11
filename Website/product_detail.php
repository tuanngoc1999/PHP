<?php include_once("header.php") ?>
<?php require_once("./entities/product.class.php");
require_once("./entities/category.class.php"); ?>

<?php
if (isset($_GET["prod_id"])) {
  $id = $_GET['prod_id'];
  $product = Product::GetProductFromID($id);
  $item = $product[0];

  $prods = Product::GetProductByCateID($item["CateID"]);

  $cateName = Category::GetCateNameFromProdID($id);
}

if (isset($_GET['request_input'])){
  echo "<script>$('#frm_dangnhap').modal('toggle');</script>";
}

?>

<style>
  .button_shopping {
    width: 160px;
  }

  * {
    box-sizing: border-box;
  }

  .img-zoom-container {
    position: relative;
  }

  .img-zoom-lens {
    position: absolute;
    border: 1px solid #d4d4d4;
    /*set the size of the lens:*/
    width: 120px;
    height: 120px;
  }

  .img-zoom-result {
    border: 1px solid #d4d4d4;
    /*set the size of the result div:*/
    width: 200px;
    height: 200px;
  }

  .value-button {
    display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 40px;
    height: 20px;
    text-align: center;
    vertical-align: middle;
    padding: 11px 0;
    background: #eee;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  .value-button {
    height: 40px;
  }

  .value-button:hover {
    cursor: pointer;
  }

  form #decrease {
    margin-right: -4px;
    border-radius: 8px 0 0 8px;
  }

  form #increase {
    margin-left: -4px;
    border-radius: 0 8px 8px 0;
  }

  form #input-wrap {
    margin: 0px;
    padding: 0px;
  }

  input#number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 40px;
    height: 40px;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
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
    left: 125px;
  }

  .place-to-hover span.btnDetail {
    left: 177px;
  }

  .place-to-hover:hover span {
    display: block;
  }

  button.detail {
    width: 45px;
    height: 45px;
  }
</style>
<script>
  function increaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    if (value < 1) {
      value = 0;
    }
    value++;
    document.getElementById('number').value = value;
  }

  function decreaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    if (value > 1) {
      value--;
    }
    document.getElementById('number').value = value;
  }

  function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);
    /*create lens:*/
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /*insert lens:*/
    img.parentElement.insertBefore(lens, img);
    /*calculate the ratio between result DIV and lens:*/
    cx = result.offsetWidth / lens.offsetWidth;
    cy = result.offsetHeight / lens.offsetHeight;
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);

    function moveLens(e) {
      var pos, x, y;
      /*prevent any other actions that may occur when moving over the image:*/
      e.preventDefault();
      /*get the cursor's x and y positions:*/
      pos = getCursorPos(e);
      /*calculate the position of the lens:*/
      x = pos.x - (lens.offsetWidth / 2);
      y = pos.y - (lens.offsetHeight / 2);
      /*prevent the lens from being positioned outside the image:*/
      if (x > img.width - lens.offsetWidth) {
        x = img.width - lens.offsetWidth;
      }
      if (x < 0) {
        x = 0;
      }
      if (y > img.height - lens.offsetHeight) {
        y = img.height - lens.offsetHeight;
      }
      if (y < 0) {
        y = 0;
      }
      /*set the position of the lens:*/
      lens.style.left = x + "px";
      lens.style.top = y + "px";
      /*display what the lens "sees":*/
      result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }

    function getCursorPos(e) {
      var a, x = 0,
        y = 0;
      e = e || window.event;
      /*get the x and y positions of the image:*/
      a = img.getBoundingClientRect();
      /*calculate the cursor's x and y coordinates, relative to the image:*/
      x = e.pageX - a.left;
      y = e.pageY - a.top;
      /*consider any page scrolling:*/
      x = x - window.pageXOffset;
      y = y - window.pageYOffset;
      return {
        x: x,
        y: y
      };
    }
  }
</script>

<div class="container-fluid" id="list_product" style="padding-top: 1%; padding-bottom: 1%;">
  <div class="row text-center">
    <!-- Cột danh mục -->
    <div class="col-sm-3">
      <!-- <div style="background-color: #BABABA; height: 50px;"><h4 style="padding-top:2%;">Danh mục</h4></div> -->
      <div class="modal-header" style="text-align: center;">
        <h3 style="width: 100%;">DANH MỤC</h3>
      </div>
      <form method="GET" action="add_to_cart.php">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Danh mục sản phẩm</h5>
          </div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=1'" style="padding-left: 10%; font-weight: 550;">Máy tính</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=2'" style="padding-left: 10%; font-weight: 550;">Laptop</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=3'" style="padding-left: 10%; font-weight: 550;">Chuột</div>
          <div class="modal-body text-left danhmuc" onclick="location.href='list_product.php?cateid=4'" style="padding-left: 10%; font-weight: 550;">Bàn phím</div>
        </div>

    </div>
    <!-- Cột chi tiết sản phẩm -->
    <div class="col-sm-9">
      <div class="modal-content">
        <div class="modal-header">
          <a href="list_product.php?cateid=<?php echo $cateName[0]['CateID'] ?>" style="width: 100%;text-align: center;">
            <h3><i class="fas fa-caret-left"></i> <strong><?php echo $cateName[0]["CategoryName"]; ?></strong></h3>
          </a>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="row img-zoom-container">
                <div class="col-sm-9">
                  <img id="myimage" src="./Image/<?php echo $item["Picture"]; ?>" class="img-responsive" width="120%" alt="Image">
                </div>
                <div class="col-sm-3" id="zoom-result">
                  <div id="myresult" class="img-zoom-result"></div>
                </div>
              </div>
              <script>
                // Initiate zoom effect:
                imageZoom("myimage", "myresult");
              </script>
            </div>
            <div class="col-sm-1">
            </div>
            <div class="col-sm-7 text-left">
              <div>
                <h3><?php echo $item["ProductName"] ?><a href="#" style="font-size: 15px;"> Xem cấu hình chi tiết</a></h3>
              </div>
              <div>
                <h5 style="color: red;">Giá <?php echo number_format($item["Price"]); ?> VND</h5>
              </div>
              <div class='dropdown-divider'></div>
              <div>
                <?php echo $item["Description"]; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div>Số lượng :</div>
          <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
          <input type="number" name="quantity" id="number" value="1" />
          <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
          <input style="display: none;" name='prod_id' type="text" value="<?php echo $item["ProductID"] ?>">
          <input style="display: none;" name='price' type="text" value="<?php echo $item["Price"] ?>">
          <input style="display: none;" name="uid" type="text" value="<?php if(isset($_SESSION['user_id']) != '') {echo $_SESSION['user_id'] ;} else {header('Location:product_detail.php?request_input');} ?>">
          <button name="btnAddToCart" type="submit" class="btn btn-primary button_shopping" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng">
            Thêm vào giỏ hàng
          </button>
          <button class="button_shopping btn btn-primary" type='button'>Mua ngay</button>
          <!-- <div style="width: 60%; background-color: #CACACA;">
                    </div> -->
        </div>
        </br></br></br>
        <div class="modal-header">
          <h4 style="width:100%; text-align: center;">Có thể bạn quan tâm</h4>
        </div>
        <div class="modal-body">
          <div class="owl-carousel owl-theme container">
            <?php foreach ($prods as $i) {
              if ($item["ProductID"] == $i["ProductID"]) {
                continue;
              } ?>
              <div class="place-to-hover">
                <div style="width:245px;">
                  <img src='./Image/<?php echo $i['Picture'] ?>' class='img-responsive' style='width:100%;margin-left: 55px;' alt='Image'>
                </div>

                <span class="btnDetail"><button type="button" onclick="location.href='product_detail.php?prod_id=<?php echo $i['ProductID'] ?>'" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Xem chi tiết"><i class="fas fa-info-circle"></i></button></span>
                <span class="btnGioHang"><button name="btnAddToCart" onclick="location.href='add_to_cart.php?uid=<?php if (isset($_SESSION['user_id']) != ''){echo $_SESSION['user_id'];} ?>&prod_id=<?php echo $i['ProductID'] ?>&quantity=1&price=<?php echo $i['Price'] ?>&btnAddToCart'" type="button" class="btn btn-primary detail" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng"><i class="fas fa-cart-plus"></i></button></span>
                <h6 style="width:245px; margin-left: 55px;" class="link_detail" onclick="location.href='product_detail.php?prod_id=<?php echo $i['ProductID'] ?>'"><?php echo $i["ProductName"]; ?></h6>i
                <h6 style="width:245px; margin-left: 55px;"><?php echo number_format($i["Price"]); ?></h6>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>

<style>
  div.modal-body.danhmuc:hover {
    cursor: pointer;
  }
</style>

<?php include_once("footer.php") ?>
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