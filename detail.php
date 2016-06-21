<?php 
	require 'templates/public/inc/header.php';
?>
<?php 
	if (!isset($_GET['idNews'])){
		header("location:index.php");
	}
	$idTT = addslashes($_GET['idNews']);
	$sqlTT = "SELECT t.idtintuc, t.iddanhmuc, t.tieude, d.tendanhmuc, t.thoigiandang, t.luotxem, t.hinhanh, t.mota,t.noidung,t.nguon FROM tintuc AS t, danhmuc AS d WHERE t.iddanhmuc = d.iddanhmuc AND t.idtintuc='$idTT'";
	//echo $sqlTT;
	$resultTT = mysql_query($sqlTT,$link);
	if (!($rowTT=mysql_fetch_array($resultTT))){
		die("Không tồn tại dữ liệu");
	}
	//Tăng lượt xem
	$sqlLuotXemTin = "UPDATE tintuc SET luotxem=luotxem+1 WHERE idtintuc='".$rowTT['idtintuc']."' LIMIT 1";
	$sqlLuotXemDanhMuc = "UPDATE danhmuc SET luotxem=luotxem+1 WHERE iddanhmuc='".$rowTT['iddanhmuc']."' LIMIT 1";
	mysql_query($sqlLuotXemTin,$link);
	mysql_query($sqlLuotXemDanhMuc,$link);
	//echo $sqlLuotXem;
	$idDanhMuc = $rowTT['iddanhmuc'];
?>
<style>
	.news_detail img{
		width:100%;
	}
</style>
	<div id="body">
		<div class="content">
			<div id="blog">
				<h2><?php echo $rowTT['tendanhmuc']?></h2>
				<div class="news_detail">
					<h1><?php echo $rowTT['tieude']?></h1>
					<p class="date">Ngày đăng: <?php echo $rowTT['thoigiandang']?> - Lượt xem: <?php echo $rowTT['luotxem']?></p>
					<div class="news_content">
						<?php echo $rowTT['noidung']?>
					</div>
					<p class="author">Nguồn: <?php echo $rowTT['nguon']?></p>
				</div>
				
				<h2>Tin tức liên quan</h2>
				<ul>
					<?php 
						$sqlTTLQ = "SELECT t.idtintuc, t.tieude, t.thoigiandang, t.luotxem, t.hinhanh,t.mota FROM tintuc AS t WHERE t.iddanhmuc = '$idDanhMuc' AND t.idtintuc!='$idTT' ORDER BY t.thoigiandang DESC,t.douutien DESC LIMIT 0 ,4 ";
						//echo $sqlTT;
						$resultTTLQ = mysql_query($sqlTTLQ,$link);
						$dataTTLQ = mysql_num_rows($resultTTLQ);
						while ($rowTTLQ=mysql_fetch_array($resultTTLQ)){
					?>
					<li>
						<div class="article">
							<h3><a href="index?idNews=<?php echo $rowTTLQ['idtintuc']?>" ><?php echo $rowTTLQ['tieude']?></a></h3>
							<small>Ngày đăng: <?php echo $rowTTLQ['thoigiandang']?></small>
							<small>Lượt xem: <?php echo $rowTTLQ['luotxem']?></small>
							<p>
								<?php echo $rowTTLQ['mota']?>								
							</p>
						</div>
						<div class="stats">
							<a href="http://vinaenter.edu.vn" class="more" target="_blank"><img src="files/<?php echo $rowTTLQ['hinhanh']?>" alt="" /></a>
						</div>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php require_once 'templates/public/inc/sidebar.php';?>
		</div>
	</div>
	<?php require_once 'templates/public/inc/footer.php';?>