<?php
	require_once '../functions/db.php';
	require_once '../functions/define.php';
	require_once '../templates/admin/inc/header.php';
?>
<?php 
	//Lấy danh sách thành viên
	$sqlTVSearch="";
	$sqlTotalSearch="";
	$taiKhoanSearch="";
	$hoVaTenSearch="";
	$capDo = $_SESSION['user']['capdo'];
	if(isset($_GET['search'])){
		$taiKhoanSearch = $_GET['taiKhoan'];
		$hoVaTenSearch = $_GET['hoVaTen'];
		if ($taiKhoanSearch!=""||$hoVaTenSearch !=""){
			if($taiKhoanSearch!=""){
				$sqlTVSearch=$sqlTVSearch." AND u.taikhoan LIKE '%$taiKhoanSearch%'";
			}
			if($hoVaTenSearch!=""){
				$sqlTVSearch=$sqlTVSearch." AND u.hovaten LIKE '%$hoVaTenSearch%'";
			}
		}
	}
		//Phân trang
		$sqlTotal = "SELECT COUNT(iduser) AS total FROM user AS u, quyen AS q WHERE q.idquyen=u.idquyen AND q.capdo>$capDo ".$sqlTVSearch;
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
		$sqlUser = "SELECT * FROM user AS u, quyen AS q WHERE u.idquyen = q.idquyen AND q.capdo>$capDo $sqlTVSearch ORDER BY q.capdo ASC LIMIT $offset , $row_count";
		//echo $sqlUser;
		$resultUser = mysql_query($sqlUser,$link);
		$dataUser = mysql_num_rows($resultUser);
	
?>	
	<div>
		<form action="" method="get" name="" class="form-inline" onsubmit="return checkSearch()" accept-charset="UTF-8" >
		 	 <div class="form-group">
		   		<label class="control-label">Tài khoản:</label>
		   		<input type="text" class="form-control" name="taiKhoan" value="<?php echo $taiKhoanSearch?>" 
		   		maxlength="200" title="Tiêu đề phải nhỏ hơn hoặc bằng 200 kí tự" />
		 	 </div>
		 	 <div class="form-group">
		   		<label class="control-label">Họ và tên:</label>
		   		<input type="text" class="form-control" name="hoVaTen" value="<?php echo $hoVaTenSearch?>" 
		   		maxlength="200" title="Tiêu đề phải nhỏ hơn hoặc bằng 200 kí tự" />
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
                  <?php if($dataUser<=0) echo "Không tồn tại dữ liệu"?>
            </span>
		</div>
	</div>
	<div>
	<form action="addUser.php" method="post" class="form-inline">
		<div class="form-group left" style="padding-right: 10px">
			<button type="submit" class="btn btn-info" >
				<img src="../templates/admin/images/add.png" alt="" width="20" height="20"> Thêm
			</button>
		</div>
	</form>
		<form action="deleteUser.php" method="post" onsubmit="return checkDelete()" class="form-inline">
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
					<th>Tài khoản</th>
					<th>Họ và tên</th>
					<th>Ngày sinh</th>
					<th>Quyền</th>
					<th>SĐT</th>
					<th>Email</th>
					<th>Địa chỉ</th>
					<th>Số bài đăng</th>
					<th>Điểm cống hiến</th>
				</tr>
				<?php 
					$stt=0;
					while ($rowUser = mysql_fetch_array($resultUser)){
						$stt++;
						$idUser = $rowUser['iduser'];
						$taiKhoan = $rowUser['taikhoan'];
						$hoVaTen = $rowUser['hovaten'];
						$ngaySinh = $rowUser['ngaysinh'];
						$quyen = $rowUser['tenquyen'];
						$soDienThoai = $rowUser['sodienthoai'];
						$email = $rowUser['email'];
						$diaChi = $rowUser['diachi'];
						$soBaiDang = $rowUser['sobaidang'];
						$diemCongHien = $rowUser['diemconghien'];
				?>
				<tr>
					<td><?php echo $stt;?></td>
					<td>
						<input type="checkbox" name="check[]" value="<?php echo $idUser?>">
					</td>
						<td><?php echo $idUser?></td>
						<td><?php echo $taiKhoan?></td>
						<td><?php echo $hoVaTen?></td>
						<td><?php echo $ngaySinh?></td>
						<td><?php echo $quyen?></td>
						<td><?php echo $soDienThoai?></td>
						<td><?php echo $email?></td>
						<td><?php echo $diaChi?></td>
						<td><?php echo $soBaiDang?></td>
						<td><?php echo $diemCongHien?></td>
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
							$urlSearch = "&taiKhoan=".$_GET['taiKhoan']."&hoVaTen=".$_GET['hoVaTen']."&search=1";
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
								<a href="indexUser.php?page=1<?php echo $urlSearch?>" <?php echo $active?>>Đầu</a>
							</li>
							<li>
								<a href="indexUser.php?page=<?php echo ($current_page-1).$urlSearch?>" <?php echo  $active?>>Trước</a>
							</li>
							<?php }?>
							<li>		
								<?php 
									if($current_page==$i){
								?>
										<a href="indexUser.php?page=<?php echo $i.$urlSearch?>" <?php echo $active?>><?php echo $i?></a>
								<?php 
									}
								?>
							</li>
							<?php 
								if($i==$sotrang){
							?>
							<li>
								<a href="indexUser.php?page=<?php echo ($current_page+1).$urlSearch?>" <?php echo $active?>>Sau</a>
							</li>
							<li>
								<a href="indexUser.php?page=<?php echo $sotrang.$urlSearch?>" <?php echo $active?>>Cuối</a>
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
