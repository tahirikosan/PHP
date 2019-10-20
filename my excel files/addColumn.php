<?php
	
	require "conn.php";
	$s_id = $_POST['s_id'];
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_id)){
			$queryUpdateColumn = mysqli_query($connection, "UPDATE `sheets` SET `maxColumn`= maxColumn + 1 WHERE s_id='$s_id'");
			$queryGetRowAndColumn =  mysqli_query($connection, "SELECT maxRow, maxColumn FROM sheets WHERE s_id='$s_id'");
			
		 if(! $queryUpdateColumn){
			 echo "SQL Hatası1 ".mysqli_error($connection);
		 }
		 if(! $queryGetRowAndColumn){
			 echo "SQL Hatası12 ".mysqli_error($connection);
		 }else{
			 $row = mysqli_fetch_assoc($queryGetRowAndColumn);
			 echo json_encode($row);
			 }
		 }
		}
	mysqli_close($connection);
?>