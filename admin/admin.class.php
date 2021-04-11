<?php 

class Admin {
    public static function CheckLogin($email, $pass){
        $db = new Db();
        $sql = "SELECT * FROM admin WHERE Email='$email' AND Password='$pass'";
        $result = $db->select_to_array($sql);

        if (count($result) > 0){
            return $result;
        }
        return false;
    }

    public static function GetUser($mail){
        $db = new Db();
        $sql = "SELECT * FROM admin WHERE Email='$mail'";
        $result = $db->select_to_array($sql);

        return $result;
    }
}

?>