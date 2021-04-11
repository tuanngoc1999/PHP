<?php

class Product{
    public $ProductName;
    public $Price;

    public function __construct($ProductName, $Price){
        $this->ProductName = $ProductName;
        $this->Price = $Price;
    }

    public static function SortRandomProduct($min, $max){
      $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS temp AS (SELECT * FROM product ORDER BY rand() LIMIT 8);SELECT * FROM temp
              WHERE Price>$min AND Price<$max";
      $db = new Db();
      $result = $db->select_to_array($sql);
      
      return $result;
    }

    public static function GetRandomProduct(){
      $db = new Db();
      $sql = "SELECT * FROM product ORDER BY rand() LIMIT 8";
      $result = $db->select_to_array($sql);

      return $result;
    }

    public static function GetProduct(){
        $db = new Db();
        $sql = "SELECT * FROM product";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function GetProductFromID($id){
        $db = new Db();
        $sql = "SELECT * FROM product WHERE ProductID=".$id;
        $result = $db->select_to_array($sql);

        return $result;
    }

    public function AddProduct($prodName, $cateID, $Price, $Quantity, $Desc, $Image){
        $db = new Db();
        $sql = "INSERT INTO product(ProductName, CateID, Price, Quantity, Description, Picture) VALUES
        ('$prodName', '$cateID', '$Price', '$Quantity', '$Desc', '$Image')";
        $result = $db->query_execute($sql);

        return $result;
    }

    public static function GetProductByPriceWithNameSearch($name, $min, $max){
      $db = new Db();
      $sql = "SELECT * FROM product WHERE ProductName LIKE '%$name%' AND Price>$min AND Price<$max";
      $result = $db->select_to_array($sql);

      if (count($result) > 0){
        return $result;
      } 
      return false; 
    }

    public function UpdateProduct($id, $prodName, $Quantity, $cateID, $Desc, $Price, $Image){
        $db = new Db();
        $sql = "UPDATE product SET ProductName='$prodName', CateID='$cateID', Price='$Price', Quantity='$Quantity', 
        Description='$Desc', Picture='$Image' WHERE ProductID=".$id;
        $result = $db->query_execute($sql);

        return $result;
    }

    public static function GetProductByCateID($cateID){
        $db = new Db();
        $sql = "SELECT * FROM product WHERE CateID='$cateID'";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public function DeleteProduct($ID){
        $db = new Db();
        $sql = "DELETE FROM product WHERE ProductID=".$ID;
        $result = $db->query_execute($sql);

        // var_dump($sql);die;

        return $result;
    }

    public static function GetProductByName($name){
      $db = new Db();
      $sql = "SELECT * FROM product WHERE ProductName LIKE'%$name%'";
      $result = $db->select_to_array($sql);
        if (count($result) == 0){
        return false;
      } else {
        return $result;
      }
    }

    public static function GetProductByPrice($min, $max){
        $db = new Db();
        $sql = "SELECT * FROM product WHERE Price>".$min." AND Price<".$max;
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function GetProductByPriceWithCateID($cateID, $min, $max){
        $db = new Db();
        $sql = "SELECT * FROM product WHERE Price>".$min." AND Price<".$max." AND CateID=".$cateID;
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function GetPopularProduct(){
        $db = new Db();
        $sql = "SELECT * FROM product INNER JOIN popularproduct ON product.ProductID = popularproduct.ProductID";
        $result = $db->select_to_array($sql);

        return $result;
    }

}
