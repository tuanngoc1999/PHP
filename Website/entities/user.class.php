<?php 

class User{
    public $email;
    public $password;
    public $F_name;
    public $L_name;
    public $address;
    public $phone;

    public function __construct($u_email, $u_pass,$u_first, $u_last, $u_address,$u_phone) {
        $this->email = $u_email;
        $this->password = $u_pass;
        $this->F_name = $u_first;
        $this->L_name = $u_last;
        $this->address = $u_address;
        $this->phone=  $u_phone;
    }

    public function SaveUser(){
        $db = new Db();
        $pass = md5($this->password);
        $sql = "INSERT INTO users (Email, Password, FirstName, LastName, Phone) VALUES
        ('$this->email', '$pass', '$this->F_name','$this->L_name' ,'$this->phone')";
        $result = $db->query_execute($sql);

        // var_dump("SQL: ".$sql."--+--".$this->email."---".$this->password."---".$this->name."---".$this->phone);die;

        return $result;
    }

    public static function GetUser(){
        $db = new Db();
        $sql = "SELECT * FROM users";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function CheckLogin($email, $password){
        $db = new Db();
        $sql = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function CheckRegister($email){
        $db = new Db();
        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public static function CheckUser($mail){
        $db = new Db();
        $sql = "SELECT * FROM users WHERE Email='$mail'";
        $result = $db->select_to_array($sql);

        return $result;
    }

    public function ChangePassword($email, $new_pass) {
        $db = new Db();
        $pass = md5($new_pass);
        $sql = "UPDATE users
                    SET Password='$pass'
                    WHERE Email='$email'";
        $result = $db->query_execute($sql);

        return $result;
    }

    
}
