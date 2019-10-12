<?php 

	$pageLimit = $_POST['pageLimit'];
	
	$connection = mysqli_connect('localhost','root','','okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryRows = mysqli_query($connection, "SELECT * FROM ogrenci;");
		$rows = mysqli_num_rows($queryRows);
		$lastPageNumber = (int)($rows / $pageLimit);
		
		echo json_encode($lastPageNumber);
	}	
?>