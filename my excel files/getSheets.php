<?php
	$connection = mysqli_connect('localhost', 'root', '', 'myexcel');
	$f_id = $_POST['f_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		//get data from database
		$queryListSheets = mysqli_query($connection, "SELECT * FROM sheets WHERE f_id='$f_id'"); 
		
		//storing data
		$data = array();
		while($row = mysqli_fetch_assoc($queryListSheets)){
			$data[] = $row;
		}
		//return response in json format
		echo json_encode($data);
	}
mysqli_close($connection);
?>