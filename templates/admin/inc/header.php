<?php 
	ob_start();
	session_start();
	require_once '../functions/checkUser.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title></title>
	<meta charset="utf-8" />
	<script type="text/javascript" src="../libraries/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../libraries/ckeditor/ckeditor.js"></script>
	<link href="../templates/admin/css/styles.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="../libraries/bootstrap.js"></script>
	<link href="../libraries/bootstrap.css" type="text/css" rel="stylesheet" />
	<link href="../libraries/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
</head>
<?php 
	$taiKhoan = $_SESSION['user']['taikhoan'];
	$idUser = $_SESSION['user']['iduser'];
	$hoVaTen = $_SESSION['user']['hovaten'];
	$capDo = $_SESSION['user']['capdo'];
	$tenQuyen = $_SESSION['user']['tenquyen'];
?>

<body class="container-fluid">
	<div style="background-color: #f1f1f1;">
		<!-- Header -->
		<div id="header">
			<!-- TOP -->
			<div class="row" style="padding: 20px;">
				<div class="col-md-6">
					<h3>
						<a href="#">Quản trị hệ thống Website báo điện tử</a>
					</h3>
				</div>
				<div class="col-md-3 col-md-offset-2" style="padding-top: 15px;">
					Chào <span class="text text-lg text-danger"><?php echo $tenQuyen?>
						<b><?php echo $hoVaTen?></b></span>
				</div>
				<div style="padding-top: 10px;">
					<a class="btn btn-danger" href="logout.php">
						<img src="../templates/admin/images/Logout-icon.png" alt="" width="20" height="20">Thoát
					</a>
				</div>
			</div>
			<!-- /TOP -->
			<!-- BOTTOM -->
			<div class="row" style="padding: 20px;">
				<!-- /LEFT -->
				<div class="col-md-2">
					<!-- Groups -->
					<div class="panel-group" id="menu-quantri">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<img
										src="../templates/admin/images/home.png" alt="" width="20" height="20">
									<a href="index.php" data-parent="#menu-quantri">Trang chủ</a>
								</h4>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<img src="../templates/admin/images/location-news-icon.png" alt="" width="20" height="20">
										<a data-toggle="collapse" data-parent="#menu-quantri" href="#tintuc">Quản trị tin tức</a>
								</h4>
							</div>
							<div id="tintuc" class="panel-collapse collapse">
								<ul class="list-group">
									<li class="list-group-item"><a href="indexNews.php">Danh sách</a></li>
									<li class="list-group-item"><a href="indexNews.php">Tìm kiếm</a></li>
									<li class="list-group-item"><a href="addNews.php">Thêm</a></li>
									<li class="list-group-item"><a href="indexNews.php">Sửa</a></li>
									<li class="list-group-item"><a href="indexNews.php">Xóa</a></li>
								</ul>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<img src="../templates/admin/images/icon-head-t.png" alt="" width="20" height="20">
										<a data-toggle="collapse" data-parent="#menu-quantri" href="#danhmuc">Quản trị danh mục</a>
								</h4>
							</div>
							<div id="danhmuc" class="panel-collapse collapse">
								<ul class="list-group">
									<li class="list-group-item"><a href="indexCat.php">Danh sách</a></li>
									<li class="list-group-item"><a href="indexCat.php">Tìm kiếm</a></li>
									<li class="list-group-item"><a href="addCat.php">Thêm</a></li>
									<li class="list-group-item"><a href="indexCat.php">Sửa</a></li>
									<li class="list-group-item"><a href="indexCat.php">Xóa</a></li>
								</ul>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<img src="../templates/admin/images/user.png" alt="" width="20" height="20">
										<a data-toggle="collapse" data-parent="#menu-quantri" href="#thanhvien">Quản trị thành viên</a>
								</h4>
							</div>
							<div id="thanhvien" class="panel-collapse collapse">
								<ul class="list-group">
									<li class="list-group-item"><a href="indexUser.php">Danh sách</a></li>
									<li class="list-group-item"><a href="indexUser.php">Tìm kiếm</a></li>
									<li class="list-group-item"><a href="addUser.php">Thêm</a></li>
									<li class="list-group-item"><a href="indexUser.php">Xóa</a></li>
								</ul>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<img src="../templates/admin/images/profile-icon-63199.png" alt="" width="20" height="20">
										<a href="infoAccount.php" data-parent="#menu-quantri">Thông tin tài khoản</a>
								</h4>
							</div>
						</div>
					</div>
				</div>
				<!-- /LEFT -->
				<!-- RIGHT -->
				<div class="col-md-10">