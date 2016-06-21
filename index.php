<?php 
	require 'templates/public/inc/header.php';
?>
	<div id="body">
		<div class="section">
			<h2>Báo điện tử</h2>
			<p class="ptop">
				Cập nhật các tin tức mới nhất, nổi bật nhất.
			</p>
			<?php
				$resultDM = mysql_query($sqlDM,$link); 
				while($rowDM = mysql_fetch_array($resultDM)){
					$idDanhMuc = $rowDM['iddanhmuc'];
		   			$tenDanhMuc = $rowDM['tendanhmuc'];
		   			$sqlTT = "SELECT t.idtintuc, t.tieude, t.thoigiandang, t.luotxem, t.hinhanh, t.mota FROM tintuc AS t WHERE 1 AND t.iddanhmuc='$idDanhMuc' ORDER BY t.thoigiandang DESC,t.douutien DESC LIMIT 5";
					$resultTT = mysql_query($sqlTT,$link);
			?>
			<!-- begin block -->
			<div class="project-wrap">
				<h3 class="title">
				<a href="cat.php?idCat=<?php echo $idDanhMuc?>"><?php echo $tenDanhMuc?></a>
				</h3>
				<?php 
					if($rowTT = mysql_fetch_array($resultTT)){
				?>
				<div class="project-top">
					<a href="index?idNews=<?php echo $rowTT['idtintuc']?>"><img src="files/<?php echo $rowTT['hinhanh']?>" alt=""></a>
					<div>
						<b><a href="detail.php?idNews=<?php echo $rowTT['idtintuc']?>"><?php echo $rowTT['tieude']?></a></b> 
						<small>Ngày đăng: <?php echo $rowTT['thoigiandang']?></small>
						<p class="preview_text">
							<?php echo $rowTT['mota']?>						
						</p>
					</div>
				</div>
				<?php 
					}
				?>
				<ul class="article">
					<?php 
						while($rowTT = mysql_fetch_array($resultTT)){
					?>
					<li>
						<a href="index?idNews=<?php echo $rowTT['idtintuc']?>"><img src="files/<?php echo $rowTT['hinhanh']?>" alt=""></a>
						<b><a href="detail.php?idNews=<?php echo $rowTT['idtintuc']?>"><?php echo $rowTT['tieude']?></a></b> 
						<small>Ngày Đăng: <?php echo $rowTT['thoigiandang']?></small>
						<p>
							<?php echo $rowTT['mota']?>
						</p>
						
					</li>
					<?php 
						}
					?>
				</ul>
				<div class="clr"></div>
			</div> <!-- end block -->
			<?php 
				}
			?>
		</div>
	
	</div>	
	