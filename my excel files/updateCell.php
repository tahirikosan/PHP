<?php

	require 'conn.php';
	$rNo = $_POST['rNo'];
	$cNo = $_POST['cNo'];
	$data = $_POST['data'];
	$s_id = $_POST['s_id'];
	
	$isCellEmpty = false;
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryCheckCell = mysqli_query($connection, "SELECT data FROM datas WHERE rNo='$rNo' AND cNo='$cNo' AND s_id='$s_id'");
		
		//check if cell is empty or not
		$row = mysqli_fetch_assoc($queryCheckCell);
		
		if(! empty($row)){
			$queryUpdateCell = mysqli_query($connection, "UPDATE datas SET data='$data' WHERE rNo='$rNo' AND cNo='$cNo' AND s_id='$s_id'"); 			
		}else{
			$queryInsertCell = mysqli_query($connection, "INSERT INTO datas(`rNo`, `cNo`, `s_id`, `data`) VALUES ('$rNo' , '$cNo' , '$s_id' , '$data')");
		}
	}
mysqli_close($connection);
?>