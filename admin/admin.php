<?php session_start() ?>
<?php
require_once("../Website/config/db.class.php");
require_once("../admin/admin.class.php");
?>

<?php

if (isset($_SESSION['admin']) == '') {
  header("Location:request_login.php");
} else {
  $admin = Admin::GetUser($_SESSION['admin']);
  $user = $admin[0];
}

?>

<?php
require_once("../Website/entities/user.class.php");
require_once("../Website/entities/category.class.php");
require_once("../Website/entities/product.class.php");
require_once("../Website/entities/order.class.php");

?>

<?php
$last_cate_id = 0;
$cate = Category::list_category();
$prods = Product::GetProduct();

if (isset($_POST['btnAddProduct'])) {
  $prodName = $_POST['txtProdName'];
  $cateID = $_POST['CateID'];
  $price = $_POST['txtPrice'];
  $quantity = $_POST['txtQuantity'];
  $desc = $_POST['txtMoTa'];
  $hinhanh = $_FILES['hinhanh']['name'];
  $path = "../Website/Image/";

  $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
  // var_dump($hinhanh);die;
  $sql = "INSERT INTO product (ProductName, CateID, Quantity, Price, Description, Picture) VALUES
    ('$prodName', '$cateID', $quantity, '$price', '$desc', '$hinhanh')";
  $db = new Db();
  $run = $db->query_execute($sql);

  if ($run) {
    echo "<script>alert('Thêm sản phẩm thành công');</script>";
    echo "<script>location.href='admin.php';</script>";
  }
  // move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
}

if (isset($_POST['btnThemDanhMuc'])) {
  $lastCateID = $_POST['txtCateID_LAST'];
  $cateName = $_POST['txtCateName'];
  $cate = new Category('', '');
  $AddCategory = $cate->AddCategory($lastCateID + 1, $cateName, 'Dang cap nhat');

  if ($AddCategory) {
    header("Location:admin.php?menu=4");
  } else {
    echo "<script>alert('Error');</script>";
    echo "<script>location.href='admin.php?menu=4';</script>";
  }
}

if (isset($_POST['btnUpdateProduct'])) {
  $prodId = $_GET['prod_id'];
  $cateID = $_POST['txtEdit_cateID'];
  $prodName = $_POST['txtEdit_name'];
  $quantity = $_POST['txtEdit_quantity'];
  $price = $_POST['txtEdit_price'];
  $desc = $_POST['txtEdit_mota'];
  $image = $_FILES['hinhanh_edit']["name"];

  $hinhanh_tmp = $_FILES['hinhanh_edit']['tmp_name'];


  $prod_update = new Product('', '');
  if ($hinhanh_tmp != "") {
    $update = $prod_update->UpdateProduct($prodId, $prodName, $quantity, $cateID, $desc, $price, $image);
    header("Location:admin.php?menu=2");
  } else {
    echo "<script>alert('Hình ảnh bạn đang bỏ trống');</script>";
  }
}

if (isset($_GET["prod_id"])) {
  $prod_edit = Product::GetProductFromID($_GET['prod_id']);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="author" content="PhamHoangQuan" />
  <link href="site.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/2a4b02d64b.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link class="jbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js">
  </script>

</head>
<style>
  p {
    font-size: 20px;
  }

  .btn.btn-outline-success.my-2.my-sm-0 {
    width: 50%;
    border: none;
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

  .button_menu:hover {
    cursor: pointer;
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
</style>

<body>
  <div class="container-fluid text-center" style=" padding-left: 5%; padding-right: 5%; padding-top: 1%;padding-bottom: 1%; background-color: #E8E8E8; ">
    <h2>TRANG ADMIN</h2>
  </div>
  <div class="container-fluid" style="margin-top: 2%;">
    <div class="row">
      <div class="col-sm-2">
        <div class="modal-content">
          <div class="modal-header">
            <h4 style="width: 100%; text-align: center;">MENU</h4>
          </div>
          <div class="button_menu modal-body" onclick="location.href='../Website/index.php'">
            <h6>Trang chủ cửa hảng</h6>
          </div>
          <div class="button_menu modal-body" onclick="MenuOption(0)">
            <h6>Thông tin admin</h6>
          </div>
          <div class="button_menu modal-body" onclick="MenuOption(1)">
            <h6>Quản lý người dùng</h6>
          </div>
          <div class="button_menu modal-body" onclick="MenuOption(2)">
            <h6>Danh sách sản phẩm</h6>
          </div>
          <div class="button_menu modal-body" onclick="MenuOption(4)">
            <h6>Danh mục sản phẩm</h6>
          </div>
          <div class="button_menu modal-body" onclick="MenuOption(3)">
            <h6>Thêm sản phẩm</h6>
          </div>
          <div class="button_menu modal-body" onclick="Logout()">
            <h6>Đăng xuất</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-10 modal-content">
        <!-- THÔNG TIN TÀI KHOẢN ADMIN -->
        <?php if (!isset($_GET['menu']) || $_GET['menu'] == 0) { ?>
          <div class="modal-header">
            <h6 style="width: 100%; text-align: center;">Thông tin tài khoản</h6>
          </div>
          <div class="modal-body">
            <h6>Thông tin cơ bản</h6>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Họ và tên</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $user['Name']; ?>" placeholder="Họ và tên" aria-label="Username" aria-describedby="basic-addon1" require>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Email</span>
              </div>
              <input require type="email" class="form-control" value="<?php echo $user['Email']; ?>" placeholder="Địa chỉ email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Số điện thoại</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $user['Phone']; ?>" placeholder="Số điện thoại" aria-label="Username" aria-describedby="basic-addon1" require>
            </div>
            <button class="btn btn-outline-primary" type="submit" name="btnSave">Lưu thay đổi</button>
            </br>
            </br>
            <h6>Thay đổi mật khẩu</h6>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Mật khẩu cũ</span>
              </div>
              <input require type="password" class="form-control" placeholder="Nhập mật khẩu cũ" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Mật khẩu mới</span>
              </div>
              <input require type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}" placeholder="Mật khâu không có ký tự đặc biệt và có ít nhất một ký tự hoa và số và phải hơn 10 ký tự" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Xác nhận mật khẩu mới</span>
              </div>
              <input require type="password" class="form-control" placeholder="Xác nhận lại mật khẩu mới" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <button class="btn btn-outline-primary" type="submit" name="btnSave_Password">Lưu mật khẩu</button>
          </div>
        <?php } ?>
        <!-- THÔNG TIN KHÁCH HÀNG -->
        <?php if (isset($_GET['menu']) && $_GET['menu'] == 1) { ?>
          <div class="modal-header">
            <h6 style="width: 100%; text-align: center;">Thông tin tài khoản người dùng</h6>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <tr class="bg-primary">
                <th style="width: 4%; text-align: center;">STT</th>
                <th style="width: 8%;">Mã KH</th>
                <th style="width: 18%;">Tên khách hàng</th>
                <th style="width: 25%;">Địa chỉ</th>
                <th style="width: 10%;">Số điện thoại </th>
                <th>Ngày mua hàng</th>
                <th style="width: 14%;">Quản lý giao dịch</th>
              </tr>
              <tr>
                <?php
                $i = 1;
                $users = User::GetUser();
                foreach ($users as $u) {
                  $order = Order::GetOrderFromUserID($u['UserID']);
                ?>
                  <td style="text-align: center;"><?php echo $i; ?></td>
                  <td><?php echo $u['UserID']; ?></td>
                  <td><?php echo $u['LastName'] . " " . $u["FirstName"]; ?></td>
                  <td><?php echo $u['Address']; ?></td>
                  <td><?php echo $u['Phone']; ?></td>
                  <td><?php if (count($order) > 0) {
                        echo $order[0]['DateOrder'];
                      } else {
                        echo "Khách hàng này chưa mua sản phẩm nào cả";
                      } ?></td>
                  <td><a href="admin.php?menu=1&giaodich=<?php echo $order[0]["OrderID"] ?>&user_id=<?php echo $u['UserID']; ?>">Xem giao dịch</a></td>
              </tr>
            <?php $i += 1;
                } ?>
            </table>
          </div>
          <?php if (isset($_GET["giaodich"])) { ?>

            <div class='modal-header'>
              <h6 style="width: 100%; text-align: center;">Chi tiết đơn hàng</h6>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                <tr class="bg-primary">
                  <th style="width: 4%; text-align: center;">STT</th>
                  <th style="width: 8%;">Mã KH</th>
                  <th style="width: 18%;">Tên khách hàng</th>
                  <th style="width: 20%;">Sản phẩm</th>
                  <th style="width: 15%;">Hình ảnh</th>
                  <th>Số lượng</th>
                  <th style="width: 14%;">Thành tiền</th>
                </tr>
                <tr>
                  <?php
                  $i = 1;
                  $users = User::GetUser();
                  foreach ($users as $u) {
                    $order = Order::GetOrderFromUserID($u['UserID']);
                    if ($_GET["user_id"] == $u["UserID"] && $_GET['giaodich'] == $order[0]["OrderID"]) { ?>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <td><?php echo $u['UserID']; ?></td>
                    <td><?php echo $u['LastName'] . " " . $u["FirstName"]; ?></td>
                    <td><?php echo $u['Address']; ?></td>
                    <td><?php echo $u['Phone']; ?></td>
                    <td><?php if (count($order) > 0) {
                          echo $order[0]['DateOrder'];
                        } else {
                          echo "Khách hàng này chưa mua sản phẩm nào cả";
                        } ?></td>
                    <td><a href="admin.php?menu=1&giaodich=<?php echo $order[0]["OrderID"] ?>&user_id=<?php echo $u['UserID']; ?>">Xem giao dịch</a></td>
                    
                    <?php } ?>
                </tr>
              <?php $i += 1;
                  } ?>
              </table>
            </div>
          <?php } ?>
        <?php } ?>
        <!-- DANH SÁCH SẢN PHẨM -->
        <?php if (isset($_GET['menu']) && $_GET['menu'] == 2) { ?>
          <div class="modal-header">
            <h6 style="width: 100%; text-align: center;">Danh sách sản phẩm bày bán</h6>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <tr class="bg-primary text-center">
                <th style="width: 4%; text-align: center;">STT</th>
                <th style="width: 15%;">Tên sản phẩm</th>
                <th style="width: 18%;">Hình ảnh</th>
                <th style="width: 2%;">Số lượng</th>
                <th style="width: 9%;">Danh mục</th>
                <th style="width: 30%;">Mô tả</th>
                <th>Giá sản phẩm</th>
                <th style="width: 10%; text-align: center;">Thao tác</th>
              </tr>
              <form method="POST">
                <?php $count = 1;
                foreach ($prods as $item) {
                  $cateName = Category::GetCateNameFromProdID($item["ProductID"]);
                ?>
                  <tr>
                    <input type="text" name="txtID" value="<?php echo $item["ProductID"]; ?>" style="display: none;">
                    <td style="text-align: center;"><?php echo $count;
                                                    $count += 1; ?></td>
                    <td><?php echo $item['ProductName']; ?></td>
                    <td style="text-align: center;"><img src="../Website/Image/<?php echo $item['Picture']; ?>" class="img-responsive" width="75%" alt="">
                    </td>
                    <td style="text-align: center;"><?php echo $item['Quantity']; ?></td>
                    <td style="text-align: center;">
                      <?php echo $cateName[0]["CategoryName"] ?>
                    </td>
                    <td style="text-align: center;">
                      <textarea readonly rows="8" style="width: 100%;"><?php echo $cateName[0]['Description']; ?></textarea>
                      <!-- <textarea class="form-control" name="txtMota_edt" style="width: 100%;" rows="10"></textarea> -->
                    </td>
                    <td><?php echo number_format($item['Price']); ?> VND</td>
                    <td style="text-align: center;">
                      <button type="button" onclick="btnXoa('<?php echo $item['ProductID']; ?>','<?php echo $item['ProductName']; ?>')" class="btn btn-danger button-functional" data-toggle="tooltip" data-placement="top" title="Xóa sản phẩm"><i class="fas fa-trash-alt"></i></button>
                      <button class="btn btn-primary button-functional" type="button" name="btnEditProduct" data-toggle="tooltip" data-placement="top" title="Sửa sản phẩm"><a href="admin.php?menu=2&prod_id=<?php echo $item["ProductID"]; ?>"><i style="color: white;" class="fas fa-edit"></i></a></button>
                    </td>
                  </tr>
                <?php } ?>

              </form>
            </table>
          </div>
        <?php } ?>
        <!-- THÊM SẢN PHẨM -->
        <?php if (isset($_GET['menu']) && $_GET['menu'] == 3) { ?>
          <form method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h6 style="width: 100%; text-align: center;">Thêm sản phẩm</h6>
            </div>
            <div class="row modal-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Tên sản phẩm</span>
                </div>
                <input type="text" class="form-control" name="txtProdName" value="" placeholder="Tên sản phẩm" aria-label="Username" aria-describedby="basic-addon1" require>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Loại sản phẩm</span>
                  <select name="CateID" style="width: 200px;">
                    <option value="" selected>-- Chọn loại --</option>
                    <?php foreach ($cate as $item) { ?>
                      <option value="<?php echo $item["CateID"] ?>"><?php echo $item["CategoryName"] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Giá</span>
                </div>
                <input type="text" name="txtPrice" class="form-control" value="" placeholder="Giá sản phẩm" aria-label="Username" aria-describedby="basic-addon1" require>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Mô tả</span>
                </div>
                <textarea name="txtMoTa" class="form-control" aria-describedby="basic-addon1" id="" style="width: 100%;" rows="5"></textarea>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Số lượng</span>
                </div>
                <!-- <input type="number" class="form-control" value="" placeholder="Giá sản phẩm" aria-label="Username"  style="width: 100px;" require> -->
                <div style="padding-left: 50px;">
                  <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                  <input type="number" name="txtQuantity" id="number" value="1" />
                  <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                </div>
              </div>
              <div class="input-group mb-3" style="width: 30%;">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Ảnh</span>
                </div>
              </div>
              <div><img id="blah" src="http://placehold.it/240" alt="Image review" width="240" style="margin-left: -200px;"></div>
              <input type="file" name="hinhanh" onchange="readURL(this);">
              <div class="input-group mb-3"></div>
              <button class="btn btn-primary" type="submit" name="btnAddProduct">Thêm sản phẩm</button>
            </div>
          </form>
        <?php } ?>

        <!-- DANH MUC SAN PHAM -->
        <?php if (isset($_GET['menu']) && $_GET['menu'] == 4) { ?>
          <form method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h6 style="width: 100%; text-align: center;">Danh mục sản phẩm</h6>
            </div>
            <div class="row modal-body">
              <div class="col-sm-4">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Loại sản phẩm</span>
                    <select name="CateID" style="width: 200px;">
                      <option value="" selected>-- Chọn loại --</option>
                      <?php foreach ($cate as $item) { ?>
                        <option value="<?php echo $item["CateID"] ?>"><?php echo $item["CategoryName"] ?></option>
                      <?php $last_cate_id = $item['CateID'];
                      } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Loại sản phẩm</span>
                  </div>
                  <input type="text" class="form-control" name="txtProdName" value="" placeholder="" aria-label="Username" aria-describedby="basic-addon1" require>
                </div>
              </div>
            </div>
            <input type="text" style="display: none;" name="txtCateID_LAST" value="<?php echo $last_cate_id; ?>">
            <div class="modal-header">
              <h6>Thêm danh mục sản phẩm</h6>
            </div>
            <div class="modal-body row">
              <div class="col-sm-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Loai sản phẩm</span>
                  </div>
                  <input type="text" name="txtCateName" class="form-control" name="txtProdName" value="" placeholder="Tên sản phẩm" aria-label="Username" aria-describedby="basic-addon1" require>
                </div>
              </div>
              <div class="col-sm-1">
                <button class="btn btn-primary" name="btnThemDanhMuc" type="submit" style="width: 120px;">Thêm</button>
              </div>
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="modal" id="frm_sua" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Chỉnh sửa sản phẩm</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" method="post">
            <div class="form-group">
              <label class="col-form-label">Tên sản phẩm</label>
              <input type="text" value="<?php echo $prod_edit[0]["ProductName"]; ?>" class="form-control" placeholder="" name="txtEdit_name" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Danh mục</label>
              <select name="txtEdit_cateID" style="width: 200px;">
                <?php
                $cateID_S = Category::GetCateNameFromProdID($_GET["prod_id"]);
                foreach ($cate as $item) {
                  if ($cateID_S[0]["CateID"] == $item["CateID"]) { ?>
                    <option value="<?php echo $item['CateID'] ?>" selected><?php echo $item['CategoryName'] ?></option>
                <?php break;
                  }
                } ?>

                <?php
                $cateID_S = Category::GetCateNameFromProdID($_GET["prod_id"]);
                foreach ($cate as $item) {
                  if ($cateID_S[0]["CateID"] == $item["CateID"]) {
                ?>
                  <?php continue;
                  } ?>
                  <option value="<?php echo $item['CateID'] ?>"><?php echo $item['CategoryName'] ?></option>
                <?php
                } ?>

              </select>
              <!-- <input type="password" class="form-control" placeholder="" id="txtRegis_password" name="txtRegis_password" required> -->
            </div>
            <div class="form-group">
              <label class="col-form-label">Hình ảnh</label>
              <input type="file" name="hinhanh_edit" require>
              <!-- <input type="password" class="form-control" placeholder="" id="txtRegis_confirm_password" name="txtRegis_confirm_password" required> -->
            </div>
            <div class="form-group">
              <label class="col-form-label">Mô tả</label>
              <!-- <input type="number" class="form-control" name="txtEdit_quantity" required> -->
              <textarea name="txtEdit_mota" style="width: 100%;" rows="10"><?php echo $prod_edit[0]["Description"]; ?></textarea>
            </div>
            <div class="form-group">
              <label class="col-form-label">Số lượng</label>
              <input type="number" class="form-control" value="<?php echo $prod_edit[0]["Quantity"]; ?>" name="txtEdit_quantity" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Giá</label>
              <input type="text" name="txtEdit_price" value="<?php echo $prod_edit[0]["Price"]; ?>" class="form-control" required>
            </div>
            <div style="text-align: center;">
              <!-- <input type="submit" class="form-control" name="dangky" value="Đăng ký"> -->
              <button name="btnUpdateProduct" class="btn btn-primary" type="submit">Lưu sản phẩm</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
<?php
if (isset($_GET["prod_id"]) && isset($_GET['menu'])) {
  echo "<script>
        $(function () {
            $('#frm_sua').modal('show');
        });
    </script>";
}
?>
<style>
  button.btn.button-functional {
    width: 45px;
  }

  .input-group-text {
    width: 205px;
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

  /* .dropdown:hover .dropbtn {background-;} */
</style>
<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah')
          .attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  function submit() {
    document.getElementById("a_sumbmit").submit();
  }

  function btnXoa(id, name) {
    option = confirm("Có muốn xóa sản phẩm: " + String(name) + "?");
    if (!option) {
      return;
    }
    location.href = 'delete_product.php?id=' + String(id);
  }

  function MenuOption(dir) {
    location.href = 'admin.php?menu=' + String(dir);
  }

  function Logout() {
    location.href = 'logout.php';
  }

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
</script>