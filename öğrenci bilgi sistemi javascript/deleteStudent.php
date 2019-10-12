<?php
$id = $_POST['id'];
$connection = mysqli_connect('localhost','root','','okul');
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		//delete data from database
	$queryListStudents = mysqli_query($connection, "DELETE FROM ogrenci WHERE id = $id"); 
	}
mysqli_close($connection);
?>