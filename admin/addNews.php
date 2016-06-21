<?php
	require_once '../functions/db.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách danh mục
	$sqlDM = "SELECT iddanhmuc,tendanhmuc FROM danhmuc";
	$resultDM = mysql_query($sqlDM,$link);
	//hàm tạo id. Gồm lengid ký tự, 
	$id = taoID($link,"tintuc","idtintuc","TT00000001");
	
?>
<script type="text/javascript">

</script>

<div>
<h2>Thêm tin tức</h2>
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
		      	<input type="text" class="form-control" name="tieuDe" required maxlength="200">
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Nguồn *</label>
		    <div class="col-sm-4">
		      	<input type="text" class="form-control" name="nguon" placeholder="Tác giả" required maxlength="200">
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
		   					echo "<option value='$idDanhMuc'>$tenDanhMuc</option>"; 
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
		   					$uuTien = "";
		   					if($i==1) $uuTien=" (Thấp nhất)";
		   					if($i==10) $uuTien=" (Cao nhất)";
		   			?>
					<option value="<?php echo $i?>"><?php echo $i.$uuTien?></option>
					<?php }?>
				</select>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Hình ảnh *</label>
		    <div class="col-sm-10">
		      	<input type="file" class="" name="hinhAnh" onchange="checkHinhAnh(this);" required accept="image/*">
		      	<span class="loi" id="loi"></span>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">
		    	
		    </label>
		    <div class="col-sm-3">
		      	<img id="img" src="../templates/admin/images/noImage.jpg" alt="img" height="108" width="180" />
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Mô tả *</label>
		    <div class="col-sm-10">
		      	<textarea rows="4" cols="50" class="" name="moTa" required maxlength="100"></textarea>
		    </div>
		 </div>
		 <div class="form-group">
		    <label class="col-sm-2 control-label">Nội dung *</label>
		    <div class="col-sm-10">
		      	<textarea rows="" cols="" class="ckeditor" name="noiDung" required></textarea>
		      	<span class="loi" id="ckloi"></span>
		    </div>
		    
		 </div>
		 <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-2">
		 		<button type="submit" class="btn btn-success" name="add">Thêm</button>
		    </div>
		    <div class="col-sm-2">
		    	<button type="reset" class="btn btn-danger" onclick="resetForm();">Nhập lại</button>
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
		var img = document.getElementById("img");
		img.src = "../templates/admin/images/noImage.jpg";
	}
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
	if(isset($_POST['add'])){
		//lấy dữ liệu từ form
		$tieuDe = mysql_escape_string($_POST['tieuDe']);
		$nguon = mysql_escape_string($_POST['nguon']);
		$danhMuc = $_POST['danhMuc'];
		$doUuTien = $_POST['doUuTien'];
		$hinhAnh="";
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
			$resultHinhAnh = move_uploaded_file($filename, $destination);
		}
		$moTa = mysql_escape_string($_POST['moTa']);
		$noiDung = mysql_escape_string($_POST['noiDung']);
		$idUser = $_SESSION['user']['iduser'];
		$sql = "INSERT INTO tintuc (idtintuc,iduser,iddanhmuc,tieude,mota,noidung,hinhanh,thoigiandang,douutien,luotxem,nguon)"
		 ."VALUES ('$id','$idUser','$danhMuc','$tieuDe','$moTa','$noiDung','$tenHinhMoi',CURDATE(),'$doUuTien','0','$nguon')";
		//echo $sql;
		$result = mysql_query($sql, $link);
		if ($result) {
			//tăng số bài đăng của user//tăng điểm cống hiến của user
			$sqlSoBaiDang = "UPDATE user SET sobaidang=sobaidang+1,diemconghien=diemconghien+1 WHERE iduser='$idUser' LIMIT 1";
			mysql_query($sqlSoBaiDang,$link);
			header("location:indexNews.php?msg=Thêm thành công");
		}else{
			echo "<p style ='color:red; text-align: center;'><strong>Có lỗi xảy ra trong quá trình thêm</strong></p>";
		}
		
	}
?>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>