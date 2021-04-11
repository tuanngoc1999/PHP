<?php
if (isset($_POST['btn_login'])) {
    session_start();
    $_SESSION['user'] = "Quan";    
    echo "<script>window.opener.location.reload('index.php')</script>";
    echo "<script>window.close();</script>";
}
?>
<script>
    function post_value() {
        opener.document.dangnhap.p_name.value = document.frm.c_name.value;
        self.close();
    }
</script>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2a4b02d64b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <form method="POST" style="width: 50%;margin:auto; padding-top: 10%;">
        <div class="form-group row">
            <label for="txtName" class="col-sm-2 form-control-label">UserName</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="txtName" placeholder="User name">
            </div>
        </div>

        <div class="form-group row">
            <label for="txtPassword" class="col-sm-2 form-control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="txtPassword" placeholder="Password">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" name="btn_login" value="Login" />
            </div>
        </div>
    </form>
</body>

</html>