<?php

	require "conn.php";
	$f_id= $_POST['f_id'];
	$update_date= $_POST['update_date'];
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($f_id)){
			$queryUpdateDate = mysqli_query($connection, "UPDATE files SET update_date='".$update_date."' WHERE f_id='$f_id'");
		 if(! $queryUpdateDate){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>