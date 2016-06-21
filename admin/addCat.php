<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách danh mục
	//$sqlDM = "SELECT iddanhmuc,tendanhmuc FROM danhmuc";
	//$resultDM = mysql_query($sqlDM,$link);
	//hàm tạo id. Gồm lengid ký tự, 
	$id = taoID($link,"danhmuc","iddanhmuc","DM001");
	
?>
<div>
<h2>Thêm danh mục</h2>
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
	<form action="" method="post"
		class="form-horizontal" onsubmit="return checkAdd()">
		<div class="form-group">
			<label class="col-sm-2 control-label" >Tên danh mục *</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="tenDanhMuc" required maxlength="50">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Mô tả *</label>
			<div class="col-sm-10">
		      	<textarea rows="4" cols="50" class="" name="moTa" required maxlength="100" ></textarea>
		    </div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-2">
				<button type="submit" class="btn btn-success" name="add">Thêm</button>
			</div>
			<div class="col-sm-2">
				<button type="reset" class="btn btn-danger" onclick="resetForm();">Nhập
					lại</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	//reset form
	function resetForm(){
		for ( instance in CKEDITOR.instances ){
	        CKEDITOR.instances[instance].setData('');
	    }
	}
	//kiem tra loc giao dich
	
	function checkAdd() {
	    var idDanhMuc;
	    if (idDanhMuc<1||idDanhMuc>99) {
	      	return false;
    	}
		
	}
</script>
<?php 
	if(isset($_POST['add'])){
		//lấy dữ liệu từ form
		$tenDanhMuc = mysql_escape_string($_POST['tenDanhMuc']);
		$moTa = mysql_escape_string($_POST['moTa']);
		//kiểm tra trùng dữ liệu
		$sqlTrung = "SELECT * FROM danhmuc WHERE tendanhmuc='$tenDanhMuc'";
		$resultTrung = mysql_query($sqlTrung,$link);
		if(mysql_num_rows($resultTrung)==1){
			header("location:addCat.php?msg=Tên danh mục đã tồn tại");
		}else{
			$sql = "INSERT INTO danhmuc (iddanhmuc,tendanhmuc,luotxem,mota)"
			 ."VALUES ('$id','$tenDanhMuc','0','$moTa')";
			//echo $sql;
			$result = mysql_query($sql, $link);
			if ($result) {
				header("location:indexCat.php?msg=Thêm thành công");
			}else{
				echo "<p style ='color:red; text-align: center;'><strong>Có lỗi xảy ra trong quá trình thêm</strong></p>";
			}
		}		
	}
?>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>