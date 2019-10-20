<?php
	
	require "conn.php";
	$s_id= $_POST['s_id'];
	$rowNumber= $_POST['rowNumber'];
	$maxRow = $_POST['maxRow'];

	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		if(!empty($s_id)){
			//query for datas
			$queryDeleteRow = mysqli_query($connection, "DELETE FROM datas WHERE rNo=$rowNumber");
			$queryUpdateDatas = mysqli_query($connection, "UPDATE datas SET rNo=(rNo - 1) WHERE s_id=$s_id AND (rNo >= $rowNumber)");
			
			//query for sheets
			$queryUpdateMaxRow = mysqli_query($connection, "UPDATE sheets SET maxRow = (maxRow - 1) WHERE s_id=$s_id ");
					
		 if(! $queryUpdateDatas){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
		}
	}
	mysqli_close($connection);
?>