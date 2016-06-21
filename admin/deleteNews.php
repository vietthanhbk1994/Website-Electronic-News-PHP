<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	if (isset($_POST['delete'])) {
		$id = join($_POST['check'],"','");
		//lấy đường dẫn ảnh cần xóa---> xóa ảnh
		$sqlPic = "SELECT hinhanh FROM tintuc WHERE idtintuc IN('$id')";
		echo  $sqlPic;
		$resultPic = mysql_query($sqlPic,$link);
		while ($rowPic = mysql_fetch_array($resultPic)){
			unlink("../files/".$rowPic['hinhanh']);
		}
		//Xóa nội dung tin tức
		$sql = "DELETE FROM tintuc WHERE idtintuc IN('$id')";
		echo $sql;
		$result = mysql_query($sql,$link);
		if ($result) {
			header("location:indexNews.php?msg=Xóa thành công!");
		}
		else{
			header("location:indexNews.php?msg=Có lỗi trong quá trình xóa!");
		}
	}
?>