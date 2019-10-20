<?php
	
	require "conn.php";
	$s_name= $_POST['s_name'];
	$f_id = $_POST['f_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_name)){
			$queryAddSheet = mysqli_query($connection, "INSERT INTO sheets (s_name, f_id, maxRow, maxColumn) VALUES ('".$s_name."', '".$f_id."', 5, 5)");
		 if(! $queryAddSheet){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>