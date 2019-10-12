<?php

$connection = mysqli_connect('localhost','root','','okul');
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		//get data from database
		$queryListStudents = mysqli_query($connection, "SELECT * FROM ogrenci ORDER BY id LIMIT 2"); 
		
		//storing data
		$data = array();
		while($row = mysqli_fetch_assoc($queryListStudents)){
			$data[] = $row;
		}
		//return response in json format
		echo json_encode($data);
	}
mysqli_close($connection);
?>