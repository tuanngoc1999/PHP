<?php require_once("../Website/config/db.class.php") ?>
<?php require_once("../admin/admin.class.php") ?>

<?php 

if (isset($_POST['btnLogin'])){
    if (isset($_POST['txtEmail']) && isset($_POST['txtPass'])){
        $e = $_POST['txtEmail'];
        $p = $_POST['txtPass'];

        $admin = Admin::CheckLogin($e,$p);

        if(!$admin){
            echo "<script>alert('Sai tài khoản hoặc mật khẩu');</script>";
            echo "<script>location.href('request_login.php')</script>";
        }else if ($admin[0]["Email"] == $e && $admin[0]["Password"] == $p){
            session_start();
            $_SESSION['admin'] = $admin[0]["Email"];
            header("Location:admin.php");
        }
    }
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

</head>

<body>
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
                        <input type="email" class="form-control" placeholder="" name="txtEmail" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="" name="txtPass" required>
                    </div>
                    <div style="text-align: center;">
                        <button name="btnLogin" class="btn btn-primary" type="submit">Đăng nhập</button>
                        <p class="text-center dont-do mt-3">Quên mật khẩu? Liên hệ đến: <strong>0798567822</strong></br>hoặc <strong>p.hoangquan8899@gmail.com</strong></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>