<?php
	
	require "conn.php";
	$f_id= $_POST['f_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($f_id)){
			$queryDeleteSheets = mysqli_query($connection, "DELETE FROM sheets WHERE f_id='$f_id'");
		 if(! $queryDeleteSheets){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>