<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách danh mục
	$sqlDM = "SELECT iddanhmuc,tendanhmuc FROM danhmuc";
	$resultDM = mysql_query($sqlDM,$link);
	$id = $_GET['id'];
	$sqlTT = "SELECT * FROM tintuc WHERE idtintuc='$id'";
	$resultTT = mysql_query($sqlTT,$link);
	$rowTT = mysql_fetch_array($resultTT);
	$idDanhMucSua = $rowTT['iddanhmuc'];
	$tieuDeSua = $rowTT['tieude'];
	$moTaSua = $rowTT['mota'];
	$noiDungSua = $rowTT['noidung'];
	$hinhAnhSua = $rowTT['hinhanh'];
	$doUuTienSua = $rowTT['douutien'];
	$nguonSua = $rowTT['nguon'];
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
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return checkAdd()">
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Tiêu đề *</label>
		    <div class="col-sm-8">
		      	<input type="text" class="form-control" name="tieuDe" required maxlength="200" value="<?php echo $tieuDeSua?>">
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Nguồn *</label>
		    <div class="col-sm-4">
		      	<input type="text" class="form-control" name="nguon" placeholder="Tác giả" required maxlength="200" value="<?php echo $nguonSua?>">
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Danh mục *</label>
		    <div class="col-sm-4">
		      	<select class="form-control" name="danhMuc">
		   			<?php 
		   				while($rowDM = mysql_fetch_array($resultDM)){
		   					$idDanhMuc = $rowDM['iddanhmuc'];
		   					$tenDanhMuc = $rowDM['tendanhmuc'];
		   					if($idDanhMuc==$idDanhMucSua){
		   						echo "<option value='$idDanhMuc' selected>$tenDanhMuc</option>";
		   					}else{
		   						echo "<option value='$idDanhMuc'>$tenDanhMuc</option>";
		   					}
		   				}
		   			?>
				</select>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Đô ưu tiên: *</label>
		    <div class="col-sm-4">
		      	<select class="form-control" name="doUuTien">
		   			<?php 
		   				for($i = 1; $i<=10; $i++){
		   					$doUuTien = "";
		   					if($i==1) $doUuTien=" (Thấp nhất)";
		   					if($i==10) $doUuTien=" (Cao nhất)";
		   			?>
					<option value="<?php echo $i?>" <?php if($i==$doUuTienSua) echo "selected";?>><?php echo $i.$doUuTien?></option>
					<?php }?>
				</select>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Hình ảnh *</label>
		    <div class="col-sm-10">
		      	<input type="file" value="" name="hinhAnh" onchange="checkHinhAnh(this);" accept="image/*">
		      	<span class="loi" id="loi"></span>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">
		    	
		    </label>
		    <div class="col-sm-3">
		      	<img id="img" src="../files/<?php echo $hinhAnhSua?>" alt="img" height="108" width="180" />
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Mô tả *</label>
		    <div class="col-sm-10">
		      	<textarea rows="4" cols="50" class="" name="moTa" required maxlength="100"><?php echo $moTaSua?></textarea>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Nội dung *</label>
		    <div class="col-sm-10">
		      	<textarea rows="" cols="" class="ckeditor" name="noiDung" required><?php echo $noiDungSua?></textarea>
		      	<span class="loi" id="ckloi"></span>
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
	function checkHinhAnh(input){
		var reader = new FileReader();
		reader.onload = function(e){
			var img = document.getElementById("img");
			img.src = e.target.result;
		};
		reader.readAsDataURL(input.files[0]);
	}
	function checkAdd() {
	    var idDanhMuc, doUuTien, hinhAnh;
	    if (idDanhMuc<1||idDanhMuc>99) {
	      	return false;
    	}
	    if (doUuTien<1||doUuTien>10) {
	      	return false;
    	}
	    //check hinh anh
	    hinhAnh = document.getElementsByName("hinhAnh")[0];
		var txt;
		if('files' in hinhAnh){
			if(hinhAnh.files.length == 1){
				var file = hinhAnh.files[0];
				if('name' in file){
					var nameFile = file.name;
					if(nameFile.length<1|| nameFile.length>50){
						//alert("Tên ảnh phải <=50 ký tự");
						document.getElementById("loi").innerHTML="Tên ảnh phải <=50 ký tự";
						return false;
					}
					var typeFile = nameFile.split('.')[nameFile.split('.').length - 1].toLowerCase();
					if(!(typeFile=="jpg"||typeFile=="jpeg"||typeFile=="gif"||typeFile=="png")){
						//alert("Không hỗ trợ hình ảnh định dạng này");
						document.getElementById("loi").innerHTML="Phải chọn file hình ảnh .jpg, .jpeg, .gif, .png";
						return false;
					}
				}
				if('size' in file){
					var sizeFile = file.size;
					if(sizeFile>(1024*1024)){//>2MB
						//alert("Kích thước ảnh phải <= 2MB");
						document.getElementById("loi").innerHTML="Kích thước ảnh phải <= 2MB";
						return false;
					}
				}
			}
		}
		//check CKEDITTOR bi bo trong
		for ( instance in CKEDITOR.instances ){
	        if((CKEDITOR.instances[instance].getData())==""){
	        	if(CKEDITOR.instances[instance].name=="noiDung"){
	        		document.getElementById("ckloi").innerHTML="Phần nội dung không được để trống";	
	        	}
	        	return false;
	        }
	    }
	}
</script>
<?php 
	if(isset($_POST['edit'])){
		//lấy dữ liệu từ form
		$tieuDe = mysql_escape_string($_POST['tieuDe']);
		$nguon = mysql_escape_string($_POST['nguon']);
		$danhMuc = $_POST['danhMuc'];
		$doUuTien = $_POST['doUuTien'];
		
		$hinhAnh=$hinhAnhSua;//nếu ko đổi thì giữ nguyên ảnh cũ
		//Xử lý hình ảnh
		if($_FILES['hinhAnh']['name']!=""){
			$hinhAnh=$_FILES['hinhAnh']['name'];
			$time = time();
			$arrName = explode(".", $hinhAnh);
			//lấy phần mở rộng
			$phanMoRong = $arrName[count($arrName)-1];
			$tenHinhMoi = "file-$time.".$phanMoRong;
			$filename = $_FILES['hinhAnh']['tmp_name'];
			$destination = "../files/".$tenHinhMoi;
			move_uploaded_file($filename, $destination);
			//xóa ảnh cũ
			$anhcu = "../files/".$hinhAnhSua;
			unlink($anhcu);
		}
		$moTa = mysql_escape_string($_POST['moTa']);
		$noiDung = mysql_escape_string($_POST['noiDung']);
		$idUser = $_SESSION['user']['iduser'];
		$sql = "UPDATE tintuc SET iddanhmuc='$danhMuc',tieude='$tieuDe',mota='$moTa',noidung='$noiDung',hinhanh='$tenHinhMoi',douutien='$doUuTien',nguon='$nguon' WHERE idtintuc='$id'";
		//echo $sql;
		$result = mysql_query($sql, $link);
		if ($result) {
			header("location:indexNews.php?msg=Sửa thành công");
		}else{
			echo "<p style ='color:red; text-align: center;'><strong>Có lỗi xảy ra trong quá trình sửa</strong></p>";
		}
		
	}
?>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>