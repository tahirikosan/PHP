<?php
	
	require "conn.php";
	$s_id= $_POST['s_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_id)){
			$queryDeleteSheets = mysqli_query($connection, "DELETE FROM datas WHERE s_id='$s_id'");
		 if(! $queryDeleteSheets){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>