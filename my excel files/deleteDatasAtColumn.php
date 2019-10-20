<?php
	
	require "conn.php";
	$s_id= $_POST['s_id'];
	$columnNumber= $_POST['columnNumber'];
	$maxColumn = $_POST['maxColumn'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_id)){
			//query for datas
			$queryDeleteColumn = mysqli_query($connection, "DELETE FROM datas WHERE cNo=$columnNumber");
			$queryUpdateDatas = mysqli_query($connection, "UPDATE datas SET cNo=(cNo - 1) WHERE s_id=$s_id AND (cNo >= $columnNumber)");
			
			//query for sheets
			$queryUpdateMaxColumn= mysqli_query($connection, "UPDATE sheets SET maxColumn = (maxColumn - 1) WHERE s_id=$s_id ");
					
		 if(! $queryUpdateDatas){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>