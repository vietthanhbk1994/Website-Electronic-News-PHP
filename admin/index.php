<?php
	require_once '../templates/admin/inc/header.php';
?>
	<div class="index-admin" style="text-align: center; font-size: 350%">
		<div class="left col-md-3">
			<a href="addNews.php">
			<img src="../templates/admin/images/location-news-icon.png"
				alt="" width="60%" height="60%">
			Thêm tin tức</a>
		</div>
		<div class="left col-md-3">
			<a href="addUser.php" >
			<img src="../templates/admin/images/user.png"
				alt="" width="60%" height="60%">
			Thêm thành viên</a>
		</div>
		<div class="left col-md-3">
			<a href="addCat.php" >
			<img src="../templates/admin/images/icon-head-t.png"
				alt="" width="60%" height="60%">
			Thêm danh mục</a>
		</div>
		<div class="left col-md-3">
			<a href="infoAccount.php" >
			<img src="../templates/admin/images/profile-icon-63199.png"
				alt="" width="60%" height="60%">
			Thông tin tài khoản</a>
		</div>
	</div>
<?php
	require_once '../templates/admin/inc/footer.php';
?>