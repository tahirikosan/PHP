<?php
	
	require "conn.php";
	$s_id= $_POST['s_id'];
	$f_id = $_POST['f_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_id)){
			$queryDeleteSheet = mysqli_query($connection, "DELETE FROM sheets WHERE s_id='$s_id' AND f_id='$f_id' LIMIT 1");
		 if(! $queryDeleteSheet){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>