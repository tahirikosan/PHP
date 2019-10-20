<?php

	require "conn.php";
	$f_name= $_POST['f_name'];
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($f_name)){
			$queryAddFile = mysqli_query($connection, "INSERT INTO files (f_name) VALUES ('".$f_name."')");
		 if(! $queryAddFile){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>