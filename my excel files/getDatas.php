<?php
	require 'conn.php';
	$s_id = $_POST['s_id'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		//get data from database
		$queryListDatas = mysqli_query($connection, "SELECT * FROM datas WHERE s_id='$s_id'"); 
		
		//storing data
		$data = array();
		while($row = mysqli_fetch_assoc($queryListDatas)){
			$data[] = $row;
		}
		//return response in json format
		echo json_encode($data);
	}
mysqli_close($connection);
?>