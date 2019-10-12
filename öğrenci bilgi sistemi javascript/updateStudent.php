<?php


	$id = $_POST['id'];
	$ad = $_POST['ad'];
	$soyad = $_POST['soyad'];
	$bolum = $_POST['bolum'];

		
//Updating the data of student
$connection = mysqli_connect('localhost', 'root', '', 'okul');
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
	$queryUpdateStudent = mysqli_query($connection, "UPDATE ogrenci SET ad='$ad', soyad='$soyad', bolum='$bolum' WHERE id=$id;");
			
		if(! $queryUpdateStudent){
			echo "SQL Hatası ".mysqli_error($connection);
		}
		if(mysqli_affected_rows($connection) == 0){
			echo "Kayıt bulunamadı (id={$id})";
		}
	}
mysqli_close($connection);
?>