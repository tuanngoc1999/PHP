<?php include_once("header.php") ?>

<?php require_once("./config/db.class.php") ?>
<?php require_once("./entities/order.class.php") ?>

<?php
$prods = Order::GetOrderFromUserID($_SESSION["user_id"]);
if (count($prods) > 0) {
  $_SESSION['order_id'] = $prods[0]["OrderID"];
}
?>

<?php if (count($prods) > 0) { ?>
</br></br>
  <div class="container-fluid row text-center">
    <div class="container">
      <h2 style="padding: 40px; padding-bottom: 10px;">Giỏ hàng</h2>
    </div>
    <div class="col-sm-9">
      <table class="table table-bordered" style="font-size: 17px;">
        <tr class="table-warning text-center">
          <!-- <th style="width: 2%;"></th> -->
          <th style="width: 5%; ">STT</th>
          <th style="width: 12%;">Sản phẩm</th>
          <th style="width: 33%;">Tên sản phẩm</th>
          <th>Số lượng</th>
          <th style="width: 16%;">Giá</th>
          <th style="width: 16%;">Tạm tính</th>
          <th></th>
        </tr>
        <?php $index = 0;
        $total = 0;
        foreach ($prods as $item) {
          $total += $item['Total'];
          $index += 1;
          $sum = $item['Quantity'] * $item['Price']; ?>
          <tr class="table-light">
            <!-- <td style="text-align: center;padding-top: 20px;">
                <input type="checkbox" value="" id="flexCheckDefault">
            </td> -->
            <form method="GET" action="update_product.php">
              <td style="text-align: center;vertical-align: middle;"><?php echo $index; ?></td>
              <input type="text" name="prod_id" style="display: none;" value="<?php echo $item['ProductID'] ?>">
              <input type="text" name="order_id" style="display: none;" value="<?php echo $item['OrderID'] ?>">
              <td><img src="./Image/<?php echo $item['Picture']; ?>" alt="Image" width="100%" class="img-responsive"></td>
              <td style="vertical-align: middle;"><?php echo $item['ProductName']; ?></td>
              <td style="vertical-align: middle;text-align: center;"><input name='quantity' type="number" value="<?php echo $item['Quantity'] ?>" class="form-control"></td>
              <td style="vertical-align: middle;text-align: center; font-weight: 400;"><?php echo number_format($item['Price']); ?> VND</td>
              <td style="vertical-align: middle;text-align: center;"><?php echo number_format($item['Total']); ?> VND</td>
              <td style='width: 3%;vertical-align: middle;'>
                <button class="btn btn-danger" style="width: 45px;margin-bottom: 5px;" type="button" onclick="location.href='delete_from_cart.php?uid=<?php echo $_SESSION['user_id']; ?>&prod_id=<?php echo $item['ProductID']; ?>&order_id=<?php echo $item['OrderID']; ?>'">
                  <i class="fas fa-trash fa-lg"></i>
                </button>
                <button class="btn btn-primary" style="width: 45px;" type="submit">
                  <i class="fas fa-sync"></i>
                </button>
              </td>
            </form>
          </tr>
        <?php } ?>
      </table>
    </div>
    <div class="col-sm-3 modal-dialog" style="margin-top: 0;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="width: 100%; text-align: center;">Thanh toán</h4>
        </div>
        <div class="modal-body">
          <table style="border: none; width: 100%;">
            <tr style='width: 100%; height: 70px;'>
              <td style="width: 50%;">Thành tiền:</td>
              <td style="width: 50%; font-weight: 650;"><?php echo number_format($total); ?> VND</td>
            </tr>
            <tr>
              <td>Hình thức thanh toán</td>
              <td>
                <div class="form-group">
                  <select class="form-control" id="exampleFormControlSelect1">
                    <option>Tiền mặt</option>
                    <option>Tài khoản ngân hàng</option>
                    <option>Ví điện tử</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td>Mã giảm giá: </td>
              <td><input type="text" class="form-control" placeholder="Nhập mã giảm giá"></td>
            </tr>
            <tr>
              <td></td>
              <td><button class="btn btn-primary" style="width: 100%;">Kiểm tra mã giảm giá</button></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <div style="width: 100%;">
            <table style="border: none; width: 100%;">
              <tr style='width: 100%;'>
                <td style="width: 50%;font-size: 22px;">Tổng số tiền:</td>
                <td style="width: 50%; font-size: 22px; font-weight: 750; color: red"><?php echo number_format($total); ?> VND</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-body">
          <button class="btn btn-warning" onclick="location.href='index.php'">Tiếp tục mua hàng</button>
          <button class="btn btn-warning">Thanh toán</button>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="container text-center" style="padding-top:30px">
    <h3 style="width: 100%; text-align: center;">Giỏ hàng trống : </h3>
    <button class="btn btn-primary" onclick="location.href='index.php'">Tiến hành mua hàng</button>
  </div>
<?php } ?>


<style>
  button.btn.btn-warning {
    width: 48%;
  }
</style>