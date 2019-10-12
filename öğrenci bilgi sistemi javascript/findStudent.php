<?php
$id = $_POST['id'];
$ad = $_POST['ad'];
$soyad = $_POST['soyad'];
$bolum = $_POST['bolum'];

$connection = mysqli_connect('localhost','root','','okul');
	
if(! $connection){
	echo "Bağlantı hatası ".mysqli_error($connection);
}else{
	$queryListStudents = mysqli_query($connection, "SELECT * FROM ogrenci WHERE id=$id or ad='$ad' or soyad='$soyad' or bolum='$bolum';");
	
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