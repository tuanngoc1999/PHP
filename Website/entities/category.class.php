<?php

require_once("C:/XAMPP/htdocs/DoAn/Website/config/db.class.php");

class Category{
    public $cateID;
    public $categoryName;
    public $description;

    public function __construct($cate_ID, $desc)
    {
        $this->cateID = $cate_ID;        
        $this->description = $desc;
    }

    public function AddCategory($cateID, $cateName, $Desc){
      $db = new Db();
      $sql = "INSERT INTO category (CateID, CategoryName, Description) VALUES ('$cateID', '$cateName', '$Desc')";
      $result = $db->query_execute($sql);

      return $result;
    }

    public static function GetCateNameFromProdID($prodID){
        $db = new Db();
        $sql = "SELECT * from category as a,product as b WHERE b.ProductID=$prodID AND a.CateID = b.CateID";
        $result = $db->select_to_array($sql);
        return $result;
    }

    public static function list_category(){
        $db = new Db();
        $sql = "SELECT * FROM category";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function GetCategory($cateID){
        $db = new Db();
        $sql = "SELECT * FROM category WHERE CateID='$cateID'";
        $result = $db->select_to_array($sql);

        if (count($result) > 0){
            return $result;            
        } else {
            return false;
        }
    }
}

?>