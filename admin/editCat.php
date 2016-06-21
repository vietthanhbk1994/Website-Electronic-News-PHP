<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy thông tin danh mục
	$id = $_GET['id'];
	$sqlIdDM = "SELECT iddanhmuc,tendanhmuc,mota FROM danhmuc WHERE iddanhmuc='$id'";
	$resultIdDM = mysql_query($sqlIdDM,$link);
	
	$rowIdDM = mysql_fetch_array($resultIdDM);
	$idDanhMuc = $rowIdDM['iddanhmuc'];
	$tenDanhMuc = $rowIdDM['tendanhmuc'];
	$moTa = $rowIdDM['mota'];
?>
<div>
<h2>Sửa tin tức</h2>
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
	<form action="" method="post" class="form-horizontal" onsubmit="return checkAdd()">
		 
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Danh mục *</label>
		    <div class="col-sm-4">
				<input type="text" class="form-control" value="<?php echo $tenDanhMuc?>" name="tenDanhMuc" required maxlength="50">
			</div>
		    </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Mô tả *</label>
		    <div class="col-sm-10">
		      	<textarea rows="4" cols="50" name="moTa" required="required" maxlength="100"> <?php echo $moTa?></textarea>
		    </div>
		 </div>
		 <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-2">
		 		<button type="submit" class="btn btn-success" name="edit">Sửa</button>
		    </div>
		    <div class="col-sm-2">
		    	<button type="reset" class="btn btn-danger" onclick="resetForm();">Nhập lại</button>
		    </div>
		 </div>
	</form>
</div>
<script type="text/javascript">
	//kiem tra loc giao dich
	function checkAdd() {
	    var idDanhMuc;
	    if (idDanhMuc<1||idDanhMuc>99) {
	      	return false;
    	}
	}
</script>
<?php 
	if(isset($_POST['edit'])){
		//lấy dữ liệu từ form
		$tenDanhMucSua = mysql_escape_string($_POST['tenDanhMuc']);
		//kiểm tra trùng dữ liệu
		$sqlTrung = "SELECT * FROM danhmuc WHERE tendanhmuc='$tenDanhMucSua' AND tendanhmuc!='$tenDanhMuc'";
		//die($sqlTrung);
		$resultTrung = mysql_query($sqlTrung,$link);
		if(mysql_num_rows($resultTrung)==1){
			header("location:editCat.php?msg=Tên danh mục đã tồn tại");
		}else{
			$moTaSua = mysql_escape_string($_POST['moTa']);
			$idUser = $_SESSION['user']['iduser'];
			$sql = "UPDATE danhmuc SET tendanhmuc='$tenDanhMucSua' ,mota='$moTaSua' WHERE iddanhmuc='$id'";
			//echo $sql;
			$result = mysql_query($sql, $link);
			if ($result) {
				header("location:indexCat.php?msg=Sửa thành công");
			}else{
				echo "<p style ='color:red; text-align: center;'><strong>Có lỗi xảy ra trong quá trình sửa</strong></p>";
			}
		}
	}
?>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>