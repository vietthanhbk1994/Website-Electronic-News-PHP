<?php
	require_once '../functions/db.php';
	require_once '../functions/define.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách danh mục
	$sqlDM = "SELECT iddanhmuc,tendanhmuc FROM danhmuc";
	$resultDM = mysql_query($sqlDM,$link);
	$sqlTTSearch="";
	$sqlTotalSearch="";
	$tieuDeSearch="";
	$danhMucSearch="";
	if(isset($_GET['search'])){
		$tieuDeSearch = $_GET['tieuDe'];
		$danhMucSearch = $_GET['danhMuc'];
		if ($tieuDeSearch!=""||$danhMucSearch!=""){
			if($tieuDeSearch!=""){
				$sqlTTSearch=$sqlTTSearch." AND t.tieude LIKE '%$tieuDeSearch%'";
			}
			if($danhMucSearch!=""){
				$sqlTTSearch=$sqlTTSearch." AND t.iddanhmuc ='$danhMucSearch'";
			}
		}
	}
		//Phân trang
		$sqlTotal = "SELECT COUNT(idtintuc) AS total FROM tintuc AS t WHERE 1".$sqlTTSearch;
		//echo $sqlTotal;
		$resultTotal = mysql_query($sqlTotal,$link);
		$rowTotal = mysql_fetch_array($resultTotal);
		$total = $rowTotal['total'];
		//Tính số trang
		$row_count = ROW_COUNT;
		$sotrang = ceil($total/$row_count);
		$current_page = 1;
		if(isset($_GET['page'])){
			$current_page = $_GET['page'];
		}
		$offset = ($current_page-1)*$row_count;
		$sqlTT = "SELECT t.idtintuc, t.tieude, u.hovaten, d.tendanhmuc, t.thoigiandang, t.luotxem, t.hinhanh, u.iduser FROM tintuc AS t, user AS u, danhmuc AS d WHERE t.iduser = u.iduser AND t.iddanhmuc = d.iddanhmuc $sqlTTSearch ORDER BY t.thoigiandang DESC,t.douutien DESC LIMIT $offset , $row_count";
		//echo $sqlTT;
		$resultTT = mysql_query($sqlTT,$link);
		$dataTT = mysql_num_rows($resultTT);
	
?>	
	<div>
		<form action="" method="get" name="" class="form-inline" onsubmit="return checkSearch()" accept-charset="UTF-8" >
		 	 <div class="form-group">
		   		<label class="control-label">Tiêu đề:</label>
		   		<input type="text" class="form-control" name="tieuDe" value="<?php echo $tieuDeSearch?>" 
		   		maxlength="200" title="Tiêu đề phải nhỏ hơn hoặc bằng 200 kí tự" />
		 	 </div>
		 	 <div class="form-group">
		   		<label class="control-label">Danh mục:</label>
		   		<select class="form-control" name="danhMuc" style="">
		   			<option value="">Tất cả</option>
		   			<?php 
		   				while($rowDM = mysql_fetch_array($resultDM)){
		   					$idDanhMuc = $rowDM['iddanhmuc'];
		   					$tenDanhMuc = $rowDM['tendanhmuc'];
		   					if($danhMucSearch==$idDanhMuc){
		   						echo "<option value='$idDanhMuc' selected>$tenDanhMuc</option>";
		   					}else{
		   						echo "<option value='$idDanhMuc'>$tenDanhMuc</option>";
		   					}
		   				}
		   			?>
				</select>
		 	 </div>
		 	 <div class="form-group">
		   		<input type="submit" class="form-control btn btn-success" id="" value="Tìm kiếm" name="search" style="width: 80px" />
		 	 </div>
		</form>
		<br />
		<div class="loi">
			<span><?php
						if(isset($_GET['msg'])){
							echo $_GET['msg'];
						}
                  ?>
                  <?php if($dataTT<=0) echo "Không tồn tại dữ liệu"?>
            </span>
		</div>
	</div>
	<div>
	<form action="addNews.php" method="post" class="form-inline">
		<div class="form-group left" style="padding-right: 10px">
			<button type="submit" class="btn btn-info" >
				<img src="../templates/admin/images/add.png" alt="" width="20" height="20"> Thêm
			</button>
		</div>
	</form>
		<form action="deleteNews.php" method="post" onsubmit="return checkDelete()" class="form-inline">
			<div>
				<div class="form-group left">
					<button type="submit" class="btn btn-danger" name="delete" >
						<img src="../templates/admin/images/del-icon.png" alt="" width="20" height="20"> Xóa
					</button>
				</div>
				<div style="color: red; text-align:center; font-weight: bold;"><span id="msg"></span></div>
				<div class="clear"></div>
			</div>
			<table class="table table-bordered table-hover">
				<tr>
					<th>STT</th>
					<th>Chọn</th>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Người đăng</th>
					<th>Danh mục</th>
					<th>Thời gian đăng</th>
					<th>Luợt xem</th>
					<th>Hình ảnh</th>
					<th>Sửa</th>
				</tr>
				<?php 
					$stt=0;
					while ($rowTT = mysql_fetch_array($resultTT)){
						$stt++;
						$idTinTuc = $rowTT['idtintuc'];
						$tieuDe = $rowTT['tieude'];
						$nguoiDang = $rowTT['hovaten'];
						$tenDanhMuc = $rowTT['tendanhmuc'];
						$thoiGianDang = $rowTT['thoigiandang'];
						$luotXem = $rowTT['luotxem'];
						$hinhAnh = $rowTT['hinhanh'];
						$urlHinhAnh = "../files/".$hinhAnh;
				?>
				<tr>
					<td><?php echo $stt;?></td>
					<td>
						<input type="checkbox" name="check[]" value="<?php echo $idTinTuc?>">
					</td>
						<td><?php echo $idTinTuc?></td>
						<td><?php echo $tieuDe?></td>
						<td><?php echo $nguoiDang?></td>
						<td><?php echo $tenDanhMuc?></td>
						<td><?php echo $thoiGianDang?></td>
						<td><?php echo $luotXem?></td>
						<td><img src="<?php echo $urlHinhAnh?>" width="150px" height="120px"></td>
						<td>
							<a href="editNews.php?id=<?php echo $idTinTuc?>">Sửa</a>
						</td>
						</tr>
				<?php }?>
			</table>
				<!-- Phân trang. -->
				<div class="right ">
					<nav>
					<ul class="pagination">
					<?php 	
						$urlSearch="";
						if(isset($_GET['search'])){
							$urlSearch = "&tieuDe=".$_GET['tieuDe']."&danhMuc=".$_GET['danhMuc']."&search=1";
						}
						$active="";
						for($i=1;$i<=$sotrang;$i++){
							if($current_page==$i){
								$active=" class= 'btn disabled'";
							}else{
								$active="";
							}
							if($i==1){
					?>
							<li>
								<a href="indexNews.php?page=1<?php echo $urlSearch?>" <?php echo $active?>>Đầu</a>
							</li>
							<li>
								<a href="indexNews.php?page=<?php echo ($current_page-1).$urlSearch?>" <?php echo  $active?>>Trước</a>
							</li>
							<?php }?>
							<li>		
								<?php 
									if($current_page==$i){
								?>
										<a href="indexNews.php?page=<?php echo $i.$urlSearch?>" <?php echo $active?>><?php echo $i?></a>
								<?php 
									}
								?>
							</li>
							<?php 
								if($i==$sotrang){
							?>
							<li>
								<a href="indexNews.php?page=<?php echo ($current_page+1).$urlSearch?>" <?php echo $active?>>Sau</a>
							</li>
							<li>
								<a href="indexNews.php?page=<?php echo $sotrang.$urlSearch?>" <?php echo $active?>>Cuối</a>
							</li>
					<?php 
								}
						}
					?>
					</ul>
					</nav>
				</div>
		</form>
	</div>
	<script type="text/javascript">
	//kiem tra xoa
	function checkDelete() {
		var check = document.getElementsByName("check[]");
		for (var i = 0; i < check.length; i++) {
			if(check[i].checked){
				return true;
			}
		}
		document.getElementById("msg").innerHTML="Chưa chọn mục để xóa";
		return false;
	}
	</script>
<?php 
	require_once '../templates/admin/inc/footer.php';
?>
