<?php

	$id = $_POST['id'];
	$ad = $_POST['ad'];
	$soyad = $_POST['soyad'];
	$bolum = $_POST['bolum'];
	
	$connection = mysqli_connect('localhost', 'root', '', 'okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($id) && !empty($ad) && !empty($soyad) && !empty($bolum)){
			$queryAddStudent = mysqli_query($connection, "INSERT INTO ogrenci (id, ad, soyad, bolum) VALUES 
				(".$id.",
				 '".$ad."',
				 '".$soyad."',
				 '".$bolum."')");
		 
		 if(! $queryAddStudent){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>