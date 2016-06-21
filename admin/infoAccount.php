<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy thông tin tài khoản
	$idUser = $_SESSION['user']['iduser'];
	$sqlIdUser = "SELECT * FROM user, quyen WHERE user.idquyen = quyen.idquyen AND iduser='$idUser'";
	$resultIdUser = mysql_query($sqlIdUser,$link);
	
	$rowIdUser = mysql_fetch_array($resultIdUser);
	$idquyen = $rowIdUser['idquyen'];
	$quyen = $rowIdUser['tenquyen'];
	$hoTen = $rowIdUser['hovaten'];
	$taiKhoan = $rowIdUser['taikhoan'];
	$matKhau = $rowIdUser['matkhau'];
	$email = $rowIdUser['email'];
	$SDT = $rowIdUser['sodienthoai'];
	$chungMinh = $rowIdUser['chungminhnhandan'];
	$diaChi = $rowIdUser['diachi'];
	$ngaySinh = $rowIdUser['ngaysinh'];
	$diemCongHien = $rowIdUser['diemconghien'];
	$soBaiDang = $rowIdUser['sobaidang'];
?>
<div>
<h2>Thông tin tài khoản</h2>
	<br/>
	<br/>
	<div class="loi">
		<span><?php
					if(isset($_GET['msg'])){
						echo $_GET['msg'];
					}
              ?>
        </span>
	</div>
	<form action="" method="post" class="form-horizontal" onsubmit="return checkAdd()" name="form">
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Tài khoản *</label>
		    <div class="col-sm-4">    	
		      	<input type="text" class="form-control" name="taiKhoan" value="<?php echo $taiKhoan?>" required maxlength="20" disabled="disabled">
		    </div>
		 </div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Mật khẩu *</label>
			<div class="col-sm-4">
				<input type="password" value="<?php echo $matKhau?>" class="form-control" name="matKhau"
					placeholder="Nhập mật khẩu mới" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{0,20}" 
						title="Mật khẩu gồm 6 đến 20 ký tự phải có cả chữ cái thường, chữ cái hoa và số"
						onchange="form.nhapLaiMatKhau.pattern = this.value;" >
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Nhập lại mật khẩu *</label>
			<div class="col-sm-4">
				<input type="password" value="<?php echo $matKhau?>" class="form-control" name="nhapLaiMatKhau"
					placeholder="Nhập mật khẩu mới" title="Nhập lại mật khẩu phải trùng với mật khẩu" onchange="form.matKhau.onchange()">
			</div>
		</div>
		<div >
			<div class="form-group">
				<label class="col-sm-2 control-label">Ngày tháng năm sinh *</label>
				<div class="col-sm-6 form-inline">
					<input class="form-control" type="date" value="<?php echo $ngaySinh?>" name="ngaySinh"  required onchange="checkAdd()"/>
					<span id="ngaySinh" class="loi"></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Họ và tên *</label>
			<div class="col-sm-4">
				<input type="text"  value="<?php echo $hoTen?>" class="form-control" name="hoVaTen"
					placeholder="" required maxlength="50">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Email *</label>
			<div class="col-sm-4">
				<input type="text" value="<?php echo $email?>" class="form-control" name="email" placeholder=""required maxlength="50">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Số điện thoại *</label>
			<div class="col-sm-4">
				<input type="text" value="<?php echo $SDT?>" class="form-control" name="soDienThoai"
					placeholder=""required maxlength="20">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Chứng minh nhân dân *</label>
			<div class="col-sm-4">
				<input type="text" value="<?php echo $chungMinh?>" class="form-control" name="chungMinhNhanDan"
					placeholder="" required maxlength="20">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Địa chỉ *</label>
			<div class="col-sm-4">
				<input type="text" value="<?php echo $diaChi?>" class="form-control" name="diaChi" placeholder=""required maxlength="100">
			</div>
		</div>
		<div class="form-group">
		    <label class="col-sm-2 control-label">Quyền *</label>
		    <div class="col-sm-4">
				<input type="text" value="<?php echo $quyen?>"  disabled="disabled" class="form-control" name="quyen" placeholder=""required maxlength="100">
			</div>
		 </div>
		<div class="form-group">
		    <label class="col-sm-2 control-label">Số bài đăng *</label>
		    <div class="col-sm-4">
				<input type="text" value="<?php echo $soBaiDang?>"  disabled="disabled" class="form-control" name="soBaiDang" placeholder=""required maxlength="100">
			</div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Điểm cống hiến *</label>
		    <div class="col-sm-4">
				<input type="text" value="<?php echo $diemCongHien?>"  disabled="disabled" class="form-control" name="diemCongHien" placeholder=""required maxlength="100">
			</div>
		 </div>
		 
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-2">
				<button type="submit" class="btn btn-success" name="update">Cập nhật</button>
			</div>
			<div class="col-sm-2">
				<button type="reset" class="btn btn-danger" onclick="">Reset</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	function checkAdd() {
		var msg = "";
		//------------Ngày tháng năm------------------
		var ngay,thang,nam;
		var d = new Date();
		var maxYear = d.getFullYear()-5;
		var minYear = maxYear-95;
		var ngaySinh = form.ngaySinh;
		var namSinh = ngaySinh.value.split("-")[0];
		if(namSinh<minYear || namSinh>maxYear){
			ngaySinh.focus();
			document.getElementById("ngaySinh").innerHTML = "Thời gian phải trong khoảng 100 năm trở lại";
			return false;
		}
	}
</script>
<?php 
	if(isset($_POST['update'])){
		//lấy dữ liệu từ form
		$matKhau = mysql_escape_string($_POST['matKhau']);
		$ngaySinh = mysql_escape_string($_POST['ngaySinh']);
		$hoTen = mysql_escape_string($_POST['hoVaTen']);
		$email = mysql_escape_string($_POST['email']);
		$SDT = mysql_escape_string($_POST['soDienThoai']);
		$chungMinh = mysql_escape_string($_POST['chungMinhNhanDan']);
		$diaChi = mysql_escape_string($_POST['diaChi']);
		$sql = "UPDATE user SET matkhau='$matKhau',ngaysinh='$ngaySinh',hovaten='$hoTen',email='$email',sodienthoai='$SDT',chungminhnhandan='$chungMinh',diachi='$diaChi'  WHERE iduser='$idUser'";
		echo $sql;
		$result = mysql_query($sql, $link);
		if ($result) {
			$_SESSION['user']['hovaten']=$hoTen;
			header("location:infoAccount.php?msg=Cập nhật thành công");
		}else{
			echo "<p style ='color:red; text-align: center;'><strong>Có lỗi xảy ra trong quá trình cập nhật</strong></p>";
		}
	}
?>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>