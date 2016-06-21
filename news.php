<?php 
	require 'templates/public/inc/header.php';
?>
<?php 
	if(!isset($_GET['search'])){
		header("location:index.php");
	}
	//Phân trang. Lấy tổng số dòng
	$sqlTotal = "SELECT COUNT(idtintuc) AS total FROM tintuc AS t WHERE 1 $sqlTTSearch";
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
	//Lấy tin tức
	$sqlTT = "SELECT t.idtintuc, t.tieude, d.tendanhmuc, t.thoigiandang, t.luotxem, t.hinhanh, t.mota FROM tintuc AS t, danhmuc AS d WHERE t.iddanhmuc = d.iddanhmuc $sqlTTSearch ORDER BY t.thoigiandang DESC, t.douutien DESC LIMIT $offset , $row_count";
	//echo $sqlTT;
	$resultTT = mysql_query($sqlTT,$link);
	$dataTT = mysql_num_rows($resultTT);
?>
	<div id="body">
		<div class="content">
			<div class="loi">
				<span>
					<?php if(isset($_GET['msg'])) echo $_GET['msg'];?>
					<?php if($dataTT<=0) echo "Không tồn tại dữ liệu"?>
				</span>
			</div>
			<div id="blog">
				<h2><?php echo "Tìm kiếm tin tức theo tiêu đề: ".$tieuDeSearch?></h2>
				<ul>
					<?php 
						while ($rowTT=mysql_fetch_array($resultTT)){
					?>
					<li>
						<div class="article">
							<h3><a href="detail.php?idNews=<?php echo $rowTT['idtintuc'] ?>" ><?php echo $rowTT['tieude']?></a></h3>
							<small>Ngày đăng: <?php echo $rowTT['thoigiandang']?> .Lượt xem: <?php echo $rowTT['luotxem']?></small>
							<p>
								<?php echo $rowTT['mota']?>			
							</p>
						</div>
						<div class="stats">
							<a href="detail.php?idNews=<?php echo $rowTT['idtintuc']?>" class="more" target="_blank"><img src="files/<?php echo $rowTT['hinhanh']?>" alt="" /></a>
						</div>
					</li>
					<?php 
						}
					?>
				</ul>
				<!-- Phân trang. -->
				<div class="right ">
					<nav>
					<ul class="pagination">
					<?php 	
						$urlSearch="";
						if(isset($_GET['search'])){
							$urlSearch = "&search=1&tieuDe=".addslashes($_GET['tieuDe']);
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
								<a href="news.php?page=1<?php echo $urlSearch?>" <?php echo $active?>>Đầu</a>
							</li>
							<li>
								<a href="news.php?page=<?php echo ($current_page-1).$urlSearch?>" <?php echo  $active?>>Trước</a>
							</li>
							<?php }?>
							<li>		
								<?php 
									if($current_page==$i){
								?>
										<a href="news.php?page=<?php echo $i.$urlSearch?>" <?php echo $active?>><?php echo $i?></a>
								<?php 
									}
								?>
							</li>
							<?php 
								if($i==$sotrang){
							?>
							<li>
								<a href="news.php?page=<?php echo ($current_page+1).$urlSearch?>" <?php echo $active?>>Sau</a>
							</li>
							<li>
								<a href="news.php?page=<?php echo $sotrang.$urlSearch?>" <?php echo $active?>>Cuối</a>
							</li>
					<?php 
								}
						}
					?>
					</ul>
					</nav>
				</div>
			</div>
			<?php require_once 'templates/public/inc/sidebar.php';?>
		</div>
	</div>
<?php require_once 'templates/public/inc/footer.php';?>