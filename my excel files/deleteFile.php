<?php

	$f_id= $_POST['f_id'];
	$connection = mysqli_connect("localhost", "root", "", "myexcel");
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($f_id)){
		$queryDeleteFile = mysqli_query($connection, "DELETE FROM files WHERE f_id = $f_id");
		 if(! $queryDeleteFile){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>