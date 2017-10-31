<?php

include "../../Connector.php";
$requestType=$_GET['requestType'];

if($requestType=='saveData')
{
	$styleId=$_GET['styleId'];
	$quentity=$_GET['quentity'];
	$cutDate=$_GET['cutDate'];
	$exFactory=$_GET['exFactory'];
	$smv=$_GET['smv'];
	$cuttingSmv=$_GET['cuttingSmv'];
	$sewingSmv=$_GET['sewingSmv'];
	$packingSmv=$_GET['packingSmv'];
	
	$sql_check="SELECT * FROM plan_newoders WHERE strStyleId='$styleId'";
	$result_check=$db->RunQuery($sql_check);
	
	$sql_check1="SELECT
				O.intStyleId,
				PN.strStyleId
				FROM
				orders O
				INNER JOIN plan_newoders PN ON O.intStyleId = PN.strStyleId
				WHERE PN.strStyleId='$styleId'";
				
	$result_check1=$db->RunQuery($sql_check1);
	
	if(mysql_num_rows($result_check)==0 && mysql_num_rows($result_check1)==0)
	{
	$sql="INSERT INTO plan_newoders (strStyleId,strDescription,dbQuantity,dtmCutCode,dtmExFactory,smv,dblCuttingSmv,dblSewwingSmv,dblPackingSmv)
		  VALUES('$styleId','$styleId','$quentity','$cutDate','$exFactory','$smv','$cuttingSmv','$sewingSmv','$packingSmv')";
	//echo($sql);	  
	$result=$db->RunQuery($sql);
	echo 1;
	}
	else
		echo 0;
}

else if($requestType='loadNewRow')
{
	$styleId=$_GET['styleId'];
	
	$sql="SELECT
			PNO.strStyleId,
			PNO.strDescription,
			PNO.dbQuantity,
			PNO.dtmCutCode,
			PNO.dtmExFactory,
			'Original' AS type,
			'Approved' AS intStatus,
			PNO.smv,
			PNO.dblCuttingSmv,
			PNO.dblSewwingSmv,
			PNO.dblPackingSmv
			FROM
		plan_newoders PNO

		WHERE strStyleId='$styleId'";
	
	$result=$db->RunQuery($sql);
	$html="";
	$row = mysql_fetch_array($result);
	
	$html .="".$row['strStyleId'].",".$row['dbQuantity'].",".$row['dtmCutCode'].",".$row['dtmExFactory'].",".$row['type'].",".$row['intStatus'].",".$row['smv'].",".$row['dblCuttingSmv'].",".$row['dblSewwingSmv'].",".$row['dblPackingSmv'];
	
	echo $html;
	
}


?>