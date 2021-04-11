<?php require_once("./config/db.class.php") ?>
<?php require_once("./entities/category.class.php") ?>
<?php require_once("./entities/product.class.php") ?>
<?php require_once("./entities/user.class.php") ?>
<?php require_once("./entities/order.class.php"); ?>

<?php
session_start();
$is_access = false;
if (isset($_SESSION['user']) != "") {
  $is_access = true;
}

if (isset($_SESSION['order_id']) != ''){
  $count = Order::GetNumberOfProductFromCart($_SESSION['order_id']);
} else {
  $count = 0;
}

if (isset($_POST['btnLogin'])) {
  $email = $_POST['txtLogin_email'];
  $password = $_POST['txtLogin_password'];
  $pass = md5($password);

  $user = User::CheckLogin($email, $pass);

  if (count($user) > 0 && $email == $user[0]["Email"] && $pass == $user[0]["Password"]) {
    $_SESSION['user'] = $user[0]["FirstName"];
    $_SESSION['user_id'] = $user[0]["UserID"];
    header("Location:index.php");
  } else {
    echo "<script>alert('Sai tên email hoặc mật khẩu');</script>";
  }
}

if (isset($_POST['btnRegister'])) {
  $email = $_POST["txtRegis_email"];
  $password = $_POST['txtRegis_password'];
  $confirm_password = $_POST['txtRegis_confirm_password'];
  $firstName = $_POST["txtRegis_firstname"];
  $lastName = $_POST["txtRegis_lastname"];
  $phone = $_POST["txtRegis_phone"];

  if ($password == $confirm_password) {
    if (count(User::CheckRegister($email)) > 0) {
      echo "<script>alert('Email đã tồn tại!')</script>";
    } else {
      $user = new User($email, $password, $firstName, $lastName, '', $phone);

      $result = $user->SaveUser();

      if ($result) {
        echo "<script>location.href = 'index.php?regis_success=$email'</script>";
      } else {
        echo "<script>alert('Đăng ký không thành công');</script>";
        echo "<script>window.reload('index.php');</script>";
      }
    }
  } else {
    echo "<script>alert('Mật khẩu xác nhận chưa hợp lệ');</script>";
  }
}

if (isset($_POST['btnGetPassword'])) {
  $pass = $_POST['txtGetPass_password'];
  $confirm = $_POST['txtGetPass_confirm_password'];
  $email = $_POST['txtGetPass_email'];

  if ($pass == $confirm) {
    $checkUser = User::CheckUser($email);
    if (count($checkUser) > 0) {
      $user = new User('', '', '', '', '', '');
      $user->ChangePassword($email, $pass);
      if (!$user) {
        echo "<script>alert('Có lỗi xảy ra');</script>";
      } else {
        echo "<script>alert('Đổi mật khẩu thành công');</script>";
        echo "<script>location.href='index.php';</script>";
      }
    } else {
      echo "<script>alert('Email không tồn tại');</script>";
      echo "<script>location.href='index.php';</script>";
    }
  } else {
    echo "<script>alert('Mật khẩu xác nhận không hợp lệ');</script>";
    echo "<script>location.href='index.php';</script>";
  }
}

if(isset($_POST['btnSearch'])){
  $searchText = addslashes($_POST['txtSearch']);
  $prodsWithName = Product::GetProductByName($searchText);

  if(!$prodsWithName){
    header("Location:list_product.php?notfound=$searchText");
  } else {
    header("Location:list_product.php?result=$searchText&list_result=$prodsWithName");
  }
  
}
?>

<?php
$cates = Category::list_category();
?>

<script>
  function popupWindow(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
  }
</script>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="author" content="YVT" />
  <link href="site.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/2a4b02d64b.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Owl Stylesheets -->
  <link rel="stylesheet" href="../OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
  <link rel="stylesheet" href="../OwlCarousel2-2.3.4/dist/assets/owl.theme.default.css">
  <script src="../OwlCarousel2-2.3.4/dist/owl.carousel.js"></script>
</head>
<body>
  <div class="container-fluid-header fixed-top">
    <div class="row">
      <div class="col-sm-2" style="padding-top: 5px;">
        <h4 style="text-align: center;" id="btnWebName" onclick="location.href='index.php'">COMPUSHOP</h4>
      </div>
      <div class="col-sm-10 text-center">
        <div class="row" style="padding-top: 5px;">
          <div class="col-lg-1" id="btnHome" onclick="location.href='index.php'">
            <p>TRANG CHỦ</p>
          </div>
          <div class="col-lg-1" id="btnProduct" onclick="location.href='list_product.php'">
            <div class="dropdown">
              <p class="dropbtn">SẢN PHẨM</p>
              <div class="dropdown-content">
                <?php
                foreach ($cates as $item) {
                  echo "<a href='list_product.php?cateid=" . $item["CateID"] . "'>" . $item["CategoryName"] . "</a>";
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-lg-1" id="btnContact" onclick="location.href='#'">
            <p>LIÊN HỆ</p>
          </div>
          <div class="col-lg-1" id="btnAbout" onclick="location.href='#'">
            <p>THÔNG TIN</p>
          </div>
          <div class="col-lg-8 ">
            <div class="row justify-content-end">
              <div class="row" style="width: 70%;">
                <form method="POST" class="row" style="width: 70%">
                  <div class="col-lg-10">
                    <input class="form-control mr-sm-2" name="txtSearch" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                  </div>
                  <div style="text-align: left; padding-top: 2.25%;">
                    <button name="btnSearch" style="border: none; outline: none; margin-top:-2px;"><i class="fas fa-search fa-lg"></i></button>
                  </div>
                </form>
              </div>
              <div style="width: 25%; ">
                <?php
                if (isset($_SESSION['user']) == "") {
                  echo "
                    <div class='form-inline my-2 my-lg-1'>
                        <button name='btnLogin' class='btn btn-outline-success my-2 my-sm-0' data-toggle='modal' data-target='#frm_dangnhap' class='text-black' style='outline:none;'>Đăng nhập</button>
                    </div>
                    ";
                } else {
                  echo "
                    <form method='POST' class='row' style='padding-top:4%;'>
                        <div class='col-1'></div>
                        <div class='col-4' style='text-align: right;'>
                            " . $_SESSION['user'] . "
                        </div>
                        <div class='col-2'>
                            <div class='dropdown' style='padding-top:3%;'>
                                <i class='fas fa-user fa-lg' style='color: black;'></i>
                                <div class='dropdown-content'>
                                    <a href='#'>Thông tin cá nhân</a>
                                    <div class='dropdown-divider'></div>
                                    <a href='logout.php'>Đăng xuất</a>
                                </div>
                            </div>
                        </div>
                        <div class='col-2'>
                            <i data-count='".$count."' onclick=location.href='shopping_cart.php' class='fas fa-shopping-cart fa-lg badge'></i>
                        </div>
                    </form>";
                }
                ?>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- DANG NHAP -->
  <div class="modal fade" id="frm_dangnhap" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Đăng nhập</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label class="col-form-label">Địa chỉ email</label>
              <input type="email" class="form-control" placeholder="" value="<?php if(isset($_GET['regis_success'])){echo $_GET['regis_success'];} else{echo "";} ?>" name="txtLogin_email" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Mật khẩu</label>
              <input type="password" class="form-control" placeholder="" name="txtLogin_password" required>
            </div>

            <div style="text-align: center;">
              <!-- <input type="submit" class="form-control" name="dangky" value="Đăng ký"> -->
              <button name="btnLogin" class="btn btn-primary" type="submit">Đăng nhập</button>
              <p class="text-center">Chưa có tại khoản?
                <a href="#" data-toggle="modal" data-target="#frm_dangky" data-dismiss="modal" data-target="#frm_dangnhap">
                  Đăng ký</a></br>
                Quên mật khẩu?
                <a href="#" data-toggle="modal" data-target="#frm_quenmatkhau" data-dismiss="modal" data-target="#frm_dangnhap">
                  Lấy lại mật khẩu</a>
              </p>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Dang ky -->
  <div class="modal fade" id="frm_dangky" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Đăng ký</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label class="col-form-label">Địa chỉ email</label>
              <input type="email" class="form-control" placeholder="Địa chỉ email" name="txtRegis_email" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Mật khẩu</label>
              <input type="password" class="form-control" placeholder="Mật khẩu có độ dài từ 12-25 ký tự" id="txtRegis_password" name="txtRegis_password" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Xác nhận lại mật khẩu</label>
              <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" id="txtRegis_confirm_password" name="txtRegis_confirm_password" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Họ và tên</label>
              </br>
              <input type="text" class="form-control" id="name_input" placeholder="Họ" name="txtRegis_lastname" required>
              <input type="text" class="form-control" id="name_input" placeholder="Tên" name="txtRegis_firstname" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Số điện thoại</label>
              <input type="tel" class="form-control" placeholder="Số điện thoại 10 số" pattern="[0-9]{10}" id="txtRegis_phone" name="txtRegis_phone" required>
            </div>

            <div style="text-align: center;">
              <!-- <input type="submit" class="form-control" name="dangky" value="Đăng ký"> -->
              <button name="btnRegister" class="btn btn-primary" type="submit">Đăng ký</button>
              <p class="text-center dont-do mt-3">Đã tài khoản?
                <a href="#" data-toggle="modal" data-target="#frm_dangnhap" data-dismiss="modal" data-target="#frm_dangky">
                  Đăng nhập</a>
              </p>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Quen mat khẩu -->
  <div class="modal fade" id="frm_quenmatkhau" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Lấy lại mật khẩu</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <div class="form-group">
              <label class="col-form-label">Địa chỉ email</label>
              <input type="email" class="form-control" placeholder="Địa chỉ email" name="txtGetPass_email" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Mật khẩu mới</label>
              <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Mật khẩu phải có ít nhất 6 ký tự và không có ký tự đặc biệt và phải chứa ít nhất 1 ký tự số và 1 ký tự in hoa" class="form-control" placeholder="Mật khẩu không có ký tự đặc biệt, có ít nhất 1 ký tự hoa và 1 ký tự số và có độ dài hơn 6 ký tự" name="txtGetPass_password" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Xác nhận lại mật khẩu</label>
              <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="txtGetPass_confirm_password" required>
            </div>
            <div style="text-align: center;">
              <button name="btnGetPassword" class="btn btn-primary" type="submit">Đổi mật khẩu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<style>
  form.row button{
    background: none;
  }
  form.row{
    height: 30px;
  }
  #name_input {
    margin-bottom: 15px;
    width: 50%;
    float: right;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    text-align: left;
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 200px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {
    background-color: #ddd;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  p {
    padding-top: 6%;
    font-size: 16px;
  }
  .badge:empty {
    display: block;
  }

  .badge:after {
    content: attr(data-count);
    position: absolute;
    background: #ff6600;
    height: 2rem;
    top: -1rem;
    right: -.4rem;
    width: 2rem;
    text-align: center;
    line-height: 2rem;
    font-size: 1rem;
    border-radius: 50%;
    color: white;
    border: 1px solid #ff6600;
    font-family: sans-serif;
    font-weight: bold;
  }
  p {
    font-size: 15px;
  }

  .btn.btn-outline-success.my-2.my-sm-0 {
    width: 50%;
    color: black;
    border: none;
    /* border-color: linear-gradient(to right bottom, rgba(255,255,255,0.7),rgba(255,255,255,0.1)); */
  }
  .btn.btn-outline-success.my-2.my-sm-0:hover{
    background-color: blue;
  color: white;
  }

  #btnHome:hover {
    cursor: pointer;
  }

  #btnProduct:hover {
    cursor: pointer;
  }

  #btnContact:hover {
    cursor: pointer;
  }

  #btnAbout:hover {
    cursor: pointer;
  }

  #btnWebName:hover {
    cursor: pointer;
  }

  i:hover {
    cursor: pointer;
  }

  .dropdown-menu.show {
    transform: translate3d(0px, 0px, 0px);

  }
  .container-fluid-header{
    /* background: linear-gradient(to right left, rgba(255,255,255,0.7),rgba(255,255,255,0.3)); */
    padding-left: 1px;
    padding-top: 8px;
    background: #fffafa;
  }
  input[type="search"]{
    background: linear-gradient(to right bottom, rgba(255,255,255,0.7),rgba(255,255,255,0.3));
  }
  .fas{
    background: none;
  }
</style>
<script>
  function popupWindow(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
  }
</script>