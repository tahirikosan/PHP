<?php

$baseUrl = "https://dl.salamquran.com/ayat/afasy-murattal-192/";
$endPoint = "001001.mp3";


$content = file_get_contents($baseUrl);

preg_match_all('#href="(.*?)"#', $content, $match_endPoints);

//echo $match_endPoints[1][4];


for($i = 4; $i < 10; $i++){
	$endPoint = $match_endPoints[1][$i];

	$ch = curl_init($baseUrl.$endPoint);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_NOBODY, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	$output = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($status == 200) {
	    file_put_contents(dirname(__FILE__) . '/quran_audios_ayats/'.$endPoint, $output);
	}else{
		echo "Error";
	}
}


?>