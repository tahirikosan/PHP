<?php
//require_once "conn.php";
$connection = mysqli_connect("localhost", "root", "", "myexcel");
if(! $connection){
	echo "Bağlantı htası".mysqli_error($connection);
}else{
	//prepare query,get data from database
	$queryForListFiles = mysqli_query($connection, "SELECT * FROM files");
	
	//check if out query is correct
	if($queryForListFiles){
		
		//storing data
		$data = array();
		while($row = mysqli_fetch_assoc($queryForListFiles)){
			$data[] = $row;
		}
		
		//return response in json format
		echo json_encode($data);
		
	}else{
		echo "SQL HATASI".mysqli_error($connection);
	}
}
 
?>