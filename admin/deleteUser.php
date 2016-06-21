<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	if (isset($_POST['delete'])) {
		$id = join($_POST['check'],"','");
		//Xóa nội dung danh mục
		$sql = "DELETE FROM user WHERE iduser IN('$id')";
		echo $sql;
		$result = mysql_query($sql,$link);
		
		if ($result) {
			header("location:indexUser.php?msg=Xóa thành công!");
		}
		else{
			header("location:indexUser.php?msg=Có lỗi trong quá trình xóa!");
		}
	}
?>