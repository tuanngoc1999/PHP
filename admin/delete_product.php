<?php
require_once("../Website/config/db.class.php");
require_once("../Website/entities/product.class.php");
if (isset($_GET["id"])){
    $id = $_GET["id"];

    $prod = new Product('','','','','','');

    $result = $prod->DeleteProduct($id);

    if (!$result){
        header("Location:admin.php?menu=2&?failure");
    } else {
        header("Location:admin.php?menu=2&?success");
    }
}?>