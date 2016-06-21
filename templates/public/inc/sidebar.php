<div id="sidebar">
	<div class="testimonials awards">
	<?php 
		$sqlTTXNN = "SELECT t.idtintuc, t.tieude, t.thoigiandang, t.luotxem, t.hinhanh, t.mota FROM tintuc AS t WHERE 1 ORDER BY t.luotxem DESC,t.thoigiandang DESC, t.douutien DESC LIMIT 4";
		//echo $sqlTT;
		$resultTTXNN = mysql_query($sqlTTXNN,$link);
		$dataTTXNN = mysql_num_rows($resultTTXNN);
	?>
		<h3>Tin tức xem nhiều nhất</h3>
		<ul>
			<?php 
				while($rowTTXNN = mysql_fetch_array($resultTTXNN)){
			?>
			<li>
				<a href="detail.php?idNews=<?php echo $rowTTXNN['idtintuc']?>">
					<img src="files/<?php echo $rowTTXNN['hinhanh']?>" alt="">
				</a>
				<b><a href="detail.php?idNews=<?php echo $rowTTXNN['idtintuc']?>"><?php echo $rowTTXNN['tieude']?></a></b>
				<small>Ngày đăng: <?php echo $rowTTXNN['thoigiandang']?></small>
				<small>Lượt xem: <?php echo $rowTTXNN['luotxem']?></small>
			</li>
			<?php
				}
			?>
		</ul>
	</div>
	<div class="testimonials awards">
	<?php 
		$sqlTTNB = "SELECT t.idtintuc, t.tieude, t.thoigiandang, t.luotxem, t.hinhanh, t.mota FROM tintuc AS t WHERE 1 ORDER BY t.douutien,t.thoigiandang DESC LIMIT 4";
		//echo $sqlTT;
		$resultTTNB = mysql_query($sqlTTNB,$link);
		$dataTTNB = mysql_num_rows($resultTTNB);
	?>
		<h3>Tin tức nổi bật</h3>
		<ul>
			<?php 
				while($rowTTNB = mysql_fetch_array($resultTTNB)){
			?>
			<li>
				<a href="detail.php?idNews=<?php echo $rowTTNB['idtintuc']?>">
					<img src="files/<?php echo $rowTTNB['hinhanh']?>" alt="">
				</a>
				<b><a href="detail.php?idNews=<?php echo $rowTTNB['idtintuc']?>"><?php echo $rowTTNB['tieude']?></a></b>
				<small>Ngày đăng: <?php echo $rowTTNB['thoigiandang']?></small>
				<small>Lượt xem: <?php echo $rowTTNB['luotxem']?></small>
			</li>
			<?php
				}
			?>
		</ul>
	</div>
</div>