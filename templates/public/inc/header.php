<?php 
	require_once 'functions/db.php';
	require_once 'functions/define.php';
?>
<?php 
	$sqlDM = "SELECT iddanhmuc,tendanhmuc FROM danhmuc";
	$resultDM = mysql_query($sqlDM,$link);
	$sqlTTSearch="";
	$tieuDeSearch="";
	if(isset($_GET['search'])){
		$tieuDeSearch = addslashes($_GET['tieuDe']);
		if($tieuDeSearch!=""){
			$sqlTTSearch=" AND t.tieude LIKE '%$tieuDeSearch%'";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Báo điện tử</title>
		<script type="text/javascript" src="libraries/jquery-2.1.4.min.js"></script>
		<link href="templates/public/css/styles.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="libraries/bootstrap.js"></script>
		<link href="libraries/bootstrap.css" type="text/css" rel="stylesheet" />
		<link href="libraries/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
	</head>
	<body class="container">
		<!-- Header -->
        <div id="header">
         	<!-- Header. Status part -->
         	<div class="header-top">
	            <div class="left header-logo">
	            	<a href="index.php">
	            		<img src="templates/public/images/logotc.png" width="200px" height="50px"/>
	            	</a>
	            </div> 
	            <!-- End #header-status -->
	            <!-- Header. Main part -->
	            <div class="header-search">
	            	<form action="news.php" method="get" class="form-inline">
						<input type="text" value="<?php echo $tieuDeSearch?>" class="form-control col-sm-4" name="tieuDe" placeholder="Nhập tiêu đề tin cần tìm kiếm" style="width: 45%;">
						<input type="submit" class="btn btn-success" name="search" value="Tìm kiếm" style="margin-left: 1%;">
	            	</form>
	            </div> 
            <!-- End #header-main -->
            </div>
            <div class="header-menu">
            	<div>
            		<ul class="nav nav-pills">
            			<li role="presentation" class="active">
            				<a href="index.php">
            					<img alt="" src="templates/public/images/home.png" width="20px" height="20px"/>
            				</a>
            			</li>
            			<?php 
            				while ($rowDM = mysql_fetch_array($resultDM)){
            			?>
            			<li role="presentation" >
            				<a href="cat.php?idCat=<?php echo $rowDM['iddanhmuc'];?>">
            					<?php echo $rowDM['tendanhmuc'];?>
            				</a>
            			</li>
            			<?php 
            				}
            			?>
            		</ul>
            	</div>
            </div>
        </div> 
         <!-- End #header -->
         