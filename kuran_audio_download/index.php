<?php 

	$conn = new mysqli("localhost", "root", "", "test");

	//Get a list of file paths using the glob function.
	$fileList = glob('quran_audios_ayats/*');
	 
	 $i = 1;
	//Loop through the array that glob returned.
	foreach($fileList as $filename){

		$sure_id = substr($filename, 19, 3);
		$verse_id = substr($filename, 22, 3) + 1;
		

	   if(!$conn){
			die('server not connected');
		}

		$query = "insert into quran_audio_ayats (id,sure_id,verse_id,verse_url) values('{$i}', '{$sure_id}','{$verse_id}', '{$filename}')";

		mysqli_query($conn, $query);

		if(mysqli_affected_rows($conn) > 0){
			echo "Audio file path saved in database";
		}

	   $i++;
	}



	
	mysqli_close($conn);



?>