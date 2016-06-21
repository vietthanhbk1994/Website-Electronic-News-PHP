<?php
	session_start();
	require_once '../functions/db.php';
?>
<html>
<head>
	<title>Đăng nhập Admin</title>
	<meta charset="utf-8" />
	<script type="text/javascript" src="../libraries/jquery-2.1.4.min.js"></script>
	<link href="../templates/admin/css/styles.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="../libraries/bootstrap.js"></script>
	<link href="../libraries/bootstrap.css" type="text/css" rel="stylesheet" />
	<link href="../libraries/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript">
	
	</script>
</head>
<body class="container" style="background-color: #f1f1f1;">
	<!-- Code ở giữa này-->
	<!-- Bắt form dang nhap -->
	<div >
		<div style="text-align:center;">
			<img src="../templates/admin/images/logotc.png" width="600px"/>
		</div>
		<div style="font-size: 400%; text-align: center;">
			<label>Trang quản trị website</label>
		</div>
		<br />
		<div class="loi" id="loi">
			<span>
			</span>
		</div>
		<br />
		<form  id="frm" action="" method="post" class="form-horizontal"
			onsubmit="return checkLogin()">
			<div class="form-group">
				<label class="col-sm-4 control-label">Tài khoản:</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="taiKhoan"
						placeholder="Nhập tài khoản" required pattern="^[A-Za-z0-9]{4,20}$"
						title="Tài khoản gồm 4 đến 20 ký tự chữ cái hoặc số"
						style="width:300px"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">Mật khẩu:</label>
				<div class="col-sm-2">
					<input type="password" class="form-control" name="matKhau"
						placeholder="Nhập mật khẩu"  required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" 
						title="Mật khẩu gồm 6 đến 20 ký tự phải có cả chữ cái thường, chữ cái hoa và số"
						style="width:300px"/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-5 col-sm-4">
					<input type="submit" name="submit" value="Đăng nhập" class="btn btn-success" />
					<input type="reset" name="reset" value="Nhập lại" class="btn btn-success" />
				</div>
			</div>
		</form>
	</div>
</body>
<?php 
	if(isset($_POST['submit'])){
		$taiKhoan = $_POST['taiKhoan'];
		$matKhau = $_POST['matKhau'];
		$sql = "SELECT u.hovaten,q.tenquyen,u.iduser,q.capdo FROM user AS u, quyen AS q WHERE u.idquyen=q.idquyen AND taikhoan ='$taiKhoan' AND matkhau='$matKhau'";
		//echo $sql;
		$result = mysql_query($sql, $link);
		$row=mysql_fetch_array($result);
		$num = mysql_num_rows($result); 
		if($num>0){
			$_SESSION['user']['hovaten']=$row['hovaten'];
			$_SESSION['user']['tenquyen']=$row['tenquyen'];
			$_SESSION['user']['iduser']=$row['iduser'];
			$_SESSION['user']['capdo']=$row['capdo'];
			$_SESSION['user']['taikhoan']=$taiKhoan;
			header("location:index.php");
		}else{
			echo "<p style ='color:red; text-align: center;'><strong>Sai tên tài khoản hoặc mật khẩu.</strong></p>";
		}
		
	}
?>