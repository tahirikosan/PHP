<?php 

$file = fopen('url.txt', 'w');



$usedUrls = ["/App_Themes/Fetva/validationengine/validationEngine.jquery.css", "/App_Themes/Fetva/bootstrap/css/bootstrap.min.css", "/App_Themes/Fetva/flags/flags.css", "/App_Themes/Fetva/css/Site.css", "/App_Themes/Fetva/font-awesome/css/font-awesome.min.css"];

$x = 0;


$endPointUrl = "";

$linkArray = [];



getLinks($endPointUrl);

$linkArray = array_unique($linkArray);

for($k = 0; $k < count($linkArray) - 1; $k++){
	echo "$linkArray[$k] <br>";
}

fclose($file);



function getLinks($endPointUrl){
	
	global $file;
	global $usedUrls;
	global $linkArray;
	//global $x;
	
	
	$baseUrl = "https://kurul.diyanet.gov.tr";
	
	
	if(@$base_content = file_get_contents("$baseUrl$endPointUrl")){
		
		preg_match_all('#href="(.*?)"#', $base_content, $match_base_url);
		
		if(count($match_base_url[1]) > 0){
			
			
			/*$x++;
			echo " $x <br>";*/
			
			for($i = 0; $i < count($match_base_url[1]); $i++){
				
			
				$endPointUrl = $match_base_url[1][$i];
				
				if(in_array($endPointUrl, $usedUrls)){
					continue;
				}
				
				echo $match_base_url[1][$i]."<br>" ;
				
				fwrite($file, $endPointUrl."\n");
				
				$usedUrls[] = $endPointUrl;   // make url to used to dont check again
				
				$linkArray[] = $endPointUrl;
				
				getLinks($endPointUrl);
			
			}
		}else{
			return;
		}
	}else{
		return;
	}
	return;
	
}








/*//soru 
preg_match_all('#<div class="panel-heading">
            <i class="fa fa-question-circle"></i>
            (.*?)
        </div>#', $base_content, $match_soru);


// cevap
preg_match_all('#<div class="panel-body">

            (.*?)

            <div>
                <div class="pull-right addthis_sharing_toolbox"></div>
            </div>
        </div>#', $base_content, $match_cevap);
		

if($match_soru != null){
	if($match_soru[1] != null){
		echo $match_soru[1][0];
	}
}

if($match_cevap != null){
	if($match_cevap[0]){
		echo $match_cevap[0][0];
	}
}
*/














/*while(){

}*/


/*$content = file_get_contents("https://kurul.diyanet.gov.tr/DiyanetSikcaTiklananlarSorular/1/Dini%20Fetva%20S%C4%B1k%C3%A7a%20Sorulan%20Sorular");

//preg_match('#<tr><th>(.*)</th> <td><b>price</b></td></tr>#', $content, $match);
preg_match_all('#href="(.*?)"#', $content, $match);
//$question = $match[];

//echo count($match[0]);

for($i = 0; $i < count($match[1]); $i++){
	//echo $match[1][$i];
	if($match[1][$i] == $first_url){
		$start_index_url = $i;
	}
	if($match[1][$i] == $last_url){
		$last_index_url = $i;
	}
}

$j = 0;
for($i = $start_index_url; $i < $last_index_url ; $i++){
	$pageUrls[$j]  = $match[1][$i];
	$j++;
}

for($i = 0; $i < count($pageUrls) ; $i++){
	echo $pageUrls[$i];
}


$content_mid = file_get_contents("$baseUrl$first_url");

preg_match_all('#href="(.*?)"#', $content_mid, $match_mid);

echo $match_mid[1][0];

*/

//$question = implode(" **** ", $match);

/*preg_match('#<input type="hidden" name="quantity_on_hand" value="(.*?)">#', $content, $match);
$in_stock = $match[1];*/

//echo "$question";



?>