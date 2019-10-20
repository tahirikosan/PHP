<?php
require_once "conn.php";
$f_id = $_POST['f_id'];

if(! $connection){
	echo "Bağlantı htası".mysqli_error($connection);
}else{
	//prepare query,get data from database
	$queryGetFileName = mysqli_query($connection, "SELECT f_name FROM files WHERE f_id='$f_id'");
	
	//check if out query is correct
	if($queryGetFileName){
		$row = mysqli_fetch_assoc($queryGetFileName);
		//return response in json format
		echo json_encode($row);
	}else{
		echo "SQL HATASI".mysqli_error($connection);
	}
}
 
?>