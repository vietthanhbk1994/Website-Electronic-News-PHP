<?php
	ob_start();//cache dữ liệu, tăng tốc độ lướt web
	$link = mysql_connect("localhost","root","") or die("Không thể kết nối đến MySQL");
	// thiet lap font chu tieng viet
	mysql_set_charset("utf8");
	mysql_select_db("baodientuphp",$link);
	
	//hàm tạo id. Gồm lengid ký tự, 
	function taoID($link,$table,$id,$idBanDau) {
		$sqlid = "SELECT MAX($id) AS id FROM $table";
		$resultid = mysql_query($sqlid,$link);
		$rowidMax = mysql_fetch_array($resultid);
		$idMax = $rowidMax['id'];
		$idMoi="";
		if($idMax!=NULL){
			$lengid = strlen($idMax);
			$lengDau="";
			for ($i=0;$i<$lengid;$i++){
				if(is_numeric($idMax{$i})){
					$lengDau=$i;
					break;
				}
			}
			//phần đầu là lengDau kí tự đầu tiên của 1 id
			$dau = substr($idMax,0,$lengDau);
			//phần đuôi mới là phần số bên phải tăng thêm 1.
			$duoi = substr($idMax,$lengDau)+1;
			//Bổ sung những chữ số 0 còn thiếu
			for ($i=strlen($duoi);$i<$lengid-$lengDau;$i++){
				$idMoi= "0".$idMoi;
			}
			$idMoi=$dau.$idMoi.$duoi;
		}else{//Tạo id lần đầu
			$idMoi = $idBanDau;
		}
		return $idMoi;
	}
?>