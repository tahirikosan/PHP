<?php
$pageNo = $_POST['pageNo'];
$pageLimit = $_POST['pageLimit'];

$connection = mysqli_connect('localhost','root','','okul');
	
if(! $connection){
	echo "Bağlantı hatası ".mysqli_error($connection);
}else{
	$queryListStudents = mysqli_query($connection, "SELECT * FROM ogrenci ORDER BY id LIMIT ".($pageNo * $pageLimit).", ".$pageLimit.";");
	
	if(! $queryListStudents){
		echo "SQL hatasi ".mysqli_error($connection);
	}else{
		
		//storing data
		$data = array();
		while($row = mysqli_fetch_assoc($queryListStudents)){
			$data[] = $row;
		}
		//return response in json
		echo json_encode($data);
	}
}

mysqli_close($connection);
?>