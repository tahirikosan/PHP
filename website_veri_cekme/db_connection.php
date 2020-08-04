<?php


// header("Content-Type: text/html; charset=UTF-8");
// /*mysqli_query("SET NAMES 'utf8'"); 
// mysqli_query('SET CHARACTER SET utf8');
// */

// $mysqli = OpenConn();
////verilerin adam akıllı utf-8 de gitmesini sağlar
// mysqli_set_charset($mysqli,"utf8");



// $listQuestion = [];
// $listAnswer = [];

// $fQuestion = fopen("question.txt", "r");
// $fAnswer = fopen("answer.txt", "r");

// $tmpQuestion = "";
// while(!feof($fQuestion)){
	// $char = fgetc($fQuestion);

   ////reset temporary question
	// if($char == "|"){
		// $listQuestion[] = $tmpQuestion;
		// $tmpQuestion = "";
	// }
	// if($char != "|"){
		// $tmpQuestion =  $tmpQuestion.$char;
	// }
	
// }

// $tmpAnswer = "";
// while(!feof($fAnswer)){
	// $char = fgetc($fAnswer);

   ////reset temporary question
	// if($char == "|"){
		// $listAnswer[] = $tmpAnswer;
		// $tmpAnswer = "";
	// }
	// if($char != "|"){
		// $tmpAnswer =  $tmpAnswer.$char;
	// }

// }

// /*echo "Sorular ve Cevaplar <br>";
// for($j = 0; $j < sizeof($listQuestion); $j++){
	// echo " Soru $listQuestion[$j]<br>Cevap $listAnswer[$j]<br>";
// }*/


////Prepare INSERT QUERY
// $insertQuery = "INSERT INTO soru_cevap (question, answer) VALUES ('$listQuestion[0]', '$listAnswer[0]')";

// for($i = 1; $i < sizeof($listQuestion) - 1; $i++){	
	// $insertQuery = $insertQuery." , ('$listQuestion[$i]', '$listAnswer[$i]')";
// }
// $insertQuery = $insertQuery." ;";

////echo $insertQuery;

// if($mysqli -> query($insertQuery)){
	// echo "başarılı";
// }else{
	// echo $mysqli-> error;
	// echo "hata";
// }




// CloseConn($mysqli);



// function OpenConn(){
	// $dbHost = "localhost";
	// $dbUser = "root";
	// $dbPass = "";
	// $db = "soru_cevap";

	// $mysqli =  new mysqli($dbHost, $dbUser, $dbPass, $db);

	// if (!$mysqli) {
	    // echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    // echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    // echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    // exit;
	// }

	// return $mysqli;
// }

// function CloseConn($mysqli){
	// $mysqli -> close();
// }

?>