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
<!-- <div class="container text-center">
    <button class="btn btn-danger" data-toggle="modal" data-target="#frm_dangnhap" class="text-black">Open Form Dang nhap</button>
    <button class="btn btn-danger" data-toggle="modal" data-target="#frm_dangky" class="text-black">Open Form Dang nhkyap</button>
</div> -->


<!-- Dang nhap -->
<div class="modal fade" id="frm_dangnhap" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <input type="email" class="form-control" placeholder="" name="txtLogin_email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="" name="txtLogin_password" required>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-form-label">Phone</label>
                        <input type="text" class="form-control" placeholder=" " name="phone" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Address</label>
                        <input type="text" class="form-control" placeholder=" " name="address" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control" placeholder=" " name="password" required="">
                        <input type="hidden" class="form-control" placeholder="" name="giaohang" value="0">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Ghi chú</label>
                        <textarea class="form-control" name="note"></textarea>
                    </div> -->

                    <div style="text-align: center;">
                        <!-- <input type="submit" class="form-control" name="dangky" value="Đăng ký"> -->
                        <button name="btnDangNhap" class="btn btn-primary" type="submit">Đăng nhập</button>
                        <button class="btn btn-primary" type="submit">Quên mật khẩu</button>
                        <p class="text-center dont-do mt-3">Chưa có tài khoản?
							<a href="#" data-toggle="modal" data-target="#frm_dangky" data-dismiss="modal" data-target="#frm_dangnhap">
								Đăng ký</a>
						</p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dang ky -->
<div class="modal fade" id="frm_dangky" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đăng ký</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label class="col-form-label">Địa chỉ email</label>
                        <input type="email" class="form-control" placeholder="" name="txtRegis_email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="" id="txtRegis_password" name="txtRegis_password" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Xác nhận lại mật khẩu</label>
                        <input type="password" class="form-control" placeholder="" id="txtRegis_confirm_password" name="txtRegis_confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Họ và tên</label>
                        </br>
                        <input type="text" class="form-control" id="name_input" placeholder="Họ" name="txtRegis_firstname" required>                        
                        <input type="text" class="form-control" id="name_input" placeholder="Tên" name="txtRegis_firstlastname" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" placeholder="Số điện thoại 10 số" pattern="[0-9]{10}" id="txtRegis_phone" name="txtRegis_phone" required>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-form-label">Phone</label>
                        <input type="text" class="form-control" placeholder=" " name="phone" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Address</label>
                        <input type="text" class="form-control" placeholder=" " name="address" required="">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control" placeholder=" " name="password" required="">
                        <input type="hidden" class="form-control" placeholder="" name="giaohang" value="0">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Ghi chú</label>
                        <textarea class="form-control" name="note"></textarea>
                    </div> -->

                    <div style="text-align: center;">
                        <!-- <input type="submit" class="form-control" name="dangky" value="Đăng ký"> -->
                        <button name="btnDangk" class="btn btn-primary" type="submit">Đăng ký</button>
                        <p class="text-center dont-do mt-3">Đã tài khoản?
							<a href="#" data-toggle="modal" data-target="#frm_dangnhap" data-dismiss="modal" data-target="#frm_dangky">
								Đăng nhập</a>
						</p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<style>
    .btn.btn-primary{
        width: 49%;
    }
    
</style>