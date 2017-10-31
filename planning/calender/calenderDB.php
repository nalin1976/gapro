<?php
	session_start();
	include "../../Connector.php";
	$intPubCompanyId		=$_SESSION["FactoryID"];
	
	$id=$_GET["id"];
	
	if($id=='save'){
	
		$intYear = $_GET["intYear"]; 
	    $intMonth = $_GET["intMonth"];
	
		$day2 = $_GET["day2"];
		
		$k =0;
		$tok = strtok($day2,"-");
		while($tok != false)
		{
			$date[$k] = $tok;
			$fullDate = $intYear."-".$intMonth."-".$date[$k];
			
			
			
			$sql = "INSERT INTO plan_holiday_calender (dtmDate) VALUES ('$fullDate')";
			$result = $db->RunQuery($sql);
			
			$tok = strtok("-");
			echo $tok;
			
			$k++;
		}
		
	}
?>
