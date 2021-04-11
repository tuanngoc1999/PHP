<?php

class Order
{
  public $productID;
  public $quantity;
  public $price;

  public function __construct($prod_id, $quantity, $price)
  {
    $this->productID = $prod_id;
    $this->quantity = $quantity;
    $this->price = $price;
  }

  public static function GetOrderFromUserID($uid)
  {
    $db = new Db();
    $sql = "SELECT b.OrderID,a.ProductID,a.ProductName,a.Price,a.Picture,c.Quantity,b.DateOrder,a.Price*c.Quantity as Total
            FROM product as a, user_order as b, order_detail as c
            WHERE b.OrderID=c.OrderID AND a.ProductID=c.ProductID AND b.UserID=$uid AND b.Status=0";
    $result = $db->select_to_array($sql);

    return $result;
  }

  public function ChangeValue($orderID, $prod_id,$quantity){
    $db = new Db();
    $sql = "UPDATE order_detail
            SET Quantity = $quantity
            WHERE OrderID=$orderID AND ProductID=$prod_id"; 
    $result = $db->query_execute($sql);

    return $result;
  }

  public static function GetNumberOfProductFromCart($orderID){
    $db = new Db();
    $sql = "SELECT SUM(Quantity) as Count FROM order_detail WHERE OrderID=$orderID";
    $result = $db->select_to_array($sql);

    return $result[0]["Count"];
  }

  public function DeleteFromOrder($prod_id, $orderID){
    $db = new Db();
    $sql = "DELETE FROM order_detail WHERE ProductID=$prod_id AND OrderID=$orderID";
    // var_dump($sql);die;
    $result = $db->query_execute($sql);

    return $result;
  }

  public function AddToCart($u_id, $prod_id, $quantity, $price)
  {
    Insert_to_user_order:
    $date = date('Y-m-d H:i:s');
    // Kiểm tra trong csdl khách hàng này đã có giỏ hàng chưa
    $db = new Db();
    $sql = "SELECT * FROM user_order WHERE UserID=$u_id AND Status = 0";
    $result = $db->select_to_array($sql);

    if (count($result) > 0) {
      // Nếu đã có giỏ hàng rồi thì chỉ cần thêm 
      // Đầu tiên ta kiểm tra xem người này đã mua món hàng này chưa nếu chưa thì thêm vào 
      // Ngược lại nếu đã có thì chỉ cần update lại tại chi tiết đơn hàng đó với (UserID và ProductID)
      $db = new Db();
      $sql = "SELECT * FROM order_detail WHERE OrderID=(SELECT OrderID FROM user_order WHERE UserID=$u_id AND Status=0) AND ProductID=$prod_id";
      $result = $db->select_to_array($sql);

      if (count($result) > 0) {
        //UPDATE
        $db = new Db();
        $sql = "UPDATE order_detail 
                  SET Quantity=Quantity+$quantity
                  WHERE OrderID=(SELECT OrderID FROM user_order WHERE UserID=$u_id) AND ProductID=$prod_id";
        $result = $db->query_execute($sql);
        return $result;
      } else {
        //INSERT
        $db = new Db();
        $sql = "INSERT INTO order_detail(OrderID, ProductID, Quantity, Price) VALUES 
                  ((SELECT OrderID FROM user_order WHERE UserID=$u_id AND Status=0) ,$prod_id, $quantity, $price)";
        $result = $db->query_execute($sql);
        return $result;
      }
    } else {
      $db = new Db();
      $sql = "INSERT INTO user_order(UserID, DateOrder,Status) VALUES ('$u_id', '$date', 0)";
      $result = $db->query_execute($sql);
      goto Insert_to_user_order;
    }
  }
}
