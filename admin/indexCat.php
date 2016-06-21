<?php
	require_once '../functions/db.php';
	require_once '../functions/define.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách danh danh muc
	$sqlDSDM = "SELECT iddanhmuc,tendanhmuc,luotxem,mota FROM danhmuc";
	$resultDSDM = mysql_query($sqlDSDM,$link);
	$sqlDMSearch="";
	$sqlTotalSearch="";
	
	$danhMucSearch="";
	if(isset($_GET['search'])){
		$danhMucSearch = $_GET['danhMuc'];
		//echo  $danhMucSearch."-----";
		if($danhMucSearch!=""){
			$sqlDMSearch=$sqlDMSearch." AND iddanhmuc ='$danhMucSearch'";
		}
	}
		//Phân trang
		$sqlTotal = "SELECT COUNT(iddanhmuc) AS total FROM danhmuc WHERE 1".$sqlDMSearch;
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
		$sqlDM = "SELECT * FROM danhmuc WHERE 1 $sqlDMSearch LIMIT $offset , $row_count";
		//echo $sqlDM;
		$resultDM = mysql_query($sqlDM,$link);
		$dataDM = mysql_num_rows($resultDM);
	
?>	
	<div>
		<form action="indexCat.php" method="get" name="" class="form-inline" onsubmit="return checkSearch()" accept-charset="UTF-8" >
			
		 	 <div class="form-group">
		   		<label class="control-label">Danh mục:</label>
		   		<select class="form-control" name="danhMuc" style="">
		   			<option value="">Tất cả</option>
		   			<?php 
		   				while($rowDSDM = mysql_fetch_array($resultDSDM)){
		   					$idDanhMuc = $rowDSDM['iddanhmuc'];
		   					$tenDanhMuc = $rowDSDM['tendanhmuc'];
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
                  <?php if($dataDM<=0) echo "Không tồn tại dữ liệu"?>
            </span>
		</div>
	</div>
	<div>
	<form action="addCat.php" method="post" class="form-inline">
		<div class="form-group left" style="padding-right: 10px">
			<button type="submit" class="btn btn-info" >
				<img src="../templates/admin/images/add.png" alt="" width="20" height="20"> Thêm
			</button>
		</div>
	</form>
		<form action="deleteCat.php" method="post" onsubmit="return checkDelete()" class="form-inline">
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
					<th>Tên danh mục</th>
					<th>Lượt xem</th>
					<th>Mô tả</th>
					<th>Sửa</th>
				</tr>
				<?php 
					$stt=0;
					while ($rowDM = mysql_fetch_array($resultDM)){
						$stt++;
						$idDanhMuc = $rowDM['iddanhmuc'];
						$tenDanhMuc = $rowDM['tendanhmuc'];
						$luotXem = $rowDM['luotxem'];
						$moTa = $rowDM['mota'];
				?>
				<tr>
					<td><?php echo $stt;?></td>
					<td>
						<input type="checkbox" name="check[]" value="<?php echo $idDanhMuc?>">
					</td>
						<td><?php echo $idDanhMuc?></td>
						<td><?php echo $tenDanhMuc?></td>
						<td><?php echo $luotXem?></td>
						<td><?php echo $moTa?></td>
						<td>
							<a href="editCat.php?id=<?php echo $idDanhMuc?>">Sửa</a>
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
							$urlSearch = "&danhMuc=".$_GET['danhMuc']."&search=1";
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
								<a href="indexCat.php?page=1<?php echo $urlSearch?>" <?php echo $active?>>Đầu</a>
							</li>
							<li>
								<a href="indexCat.php?page=<?php echo ($current_page-1).$urlSearch?>" <?php echo  $active?>>Trước</a>
							</li>
							<?php }?>
							<li>		
								<?php 
									if($current_page==$i){
								?>
										<a href="indexCat.php?page=<?php echo $i.$urlSearch?>" <?php echo $active?>><?php echo $i?></a>
								<?php 
									}
								?>
							</li>
							<?php 
								if($i==$sotrang){
							?>
							<li>
								<a href="indexCat.php?page=<?php echo ($current_page+1).$urlSearch?>" <?php echo $active?>>Sau</a>
							</li>
							<li>
								<a href="indexCat.php?page=<?php echo $sotrang.$urlSearch?>" <?php echo $active?>>Cuối</a>
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