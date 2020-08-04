<?php

include'db_connection.php';

//$conn = OpenConn();

$questionList = [];
$answerList = [];


$baseUrl = "https://kurul.diyanet.gov.tr";

$urlList = [];

$file = fopen("url.txt", 'r');
$fQuestion = fopen("question.txt", 'w');
$fAnswer = fopen("answer.txt", 'w');
$fSubject = fopen("subject.txt", 'w');
$fData = fopen("data.txt", "w");

while(!feof($file)){
	$urlList[] =  fgets($file);
}

$id = 0;
for($i = 40 ; $i < sizeof($urlList); $i++){

	//echo $i."<br>";

	if(@$content = file_get_contents("$baseUrl$urlList[$i]")){

		//soru 
		preg_match('#<div class="panel-heading">
            <i class="fa fa-question-circle"></i>
            (.*?)
        </div>#', $content, $match_soru);

		//print_r($match_soru);

		/*if(sizeof($match_soru) > 0){
			$questionList[] = $match_soru[1];
			fwrite($fQuestion, $match_soru[1]."|");
		}*/

		

		// cevap
		preg_match('#<div class="panel-body">

            (.*?)

            <div>#', $content, $match_cevap);


		// get subject in bad formnat
		preg_match('#<a href="/Konu-Cevap-Ara/(.*?)">#', $content, $match_subject);

		// get subject in fixed format
		$preg = '#<a href="/Konu-Cevap-Ara/'.$match_subject[1].'">(.*?)</a>#';
		preg_match($preg, $content, $match_subject);

		// get subject in fizex format


	

		if(sizeof($match_soru) > 0 && sizeof($match_cevap) > 0 && sizeof($match_subject) > 0){
			$questionList[] = $match_soru[1];
		    $answerList[] = $match_cevap[1];
		    $subjectList[] = $match_subject[1];

		    fwrite($fQuestion, $match_soru[1]."|");
		    fwrite($fAnswer, $match_cevap[1]."|");
		    fwrite($fSubject, $match_subject[1]."|");
		    fwrite($fData, $id."|".$match_soru[1]."|".$match_cevap[1]."|".$match_subject[1]."|"."$baseUrl"."\n");

		    $id++;

		}

	}
}

/*echo "Sorular ve Cevaplar <br>";
for($j = 0; $j < sizeof($questionList); $i++){
	echo " Soru $questionList[$j]<br>Cevap $answerList[$j]<br>";
}*/


// Prepare INSERT QUERY
/*$insertQuery = "INSERT INTO soru_cevap (question, answer) VALUES ('$questionList[0]', '$answerList[0]')";

for($i = 1; $i < sizeof($questionList) - 1; $i++){	
	$insertQuery = $insertQuery." , ('$questionList[$i]', '$answerList[$i]')";
}
$insertQuery = $insertQuery." ;";



if(mysqli_query($conn, $insertQuery)){
	echo "başarılı";
}*/


fclose($file);
fclose($fQuestion);
fclose($fAnswer);
fclose($fData);
fclose($fSubject);




//CloseConn($conn);

?>