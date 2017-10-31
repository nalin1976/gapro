<?php
include "../../Connector.php";
$strButton=$_GET["requestType"];
	
if($strButton=="saveQualityDetails")
{	
	$qualitycd   =$_GET["qualitycd"];
	$quality     =$_GET["quality"];
	$qualityRmrks=$_GET["qualityRmrks"];
	$intStatus   =$_GET["intStatus"];
	
	  $sql_insert  = "INSERT INTO quality (strQualityCode,strQuality,strRemarks,intStatus) values
					 ('$qualitycd','$quality','$qualityRmrks','$intStatus')";
	  $result      = $db->ExecuteQuery($sql_insert);
	  		
	  if($result)
	  
		echo 1;
		
	  else
	  
		echo 0;	
}
if($strButton=="updateQualityDetails")
{  
$cboQuality  =$_GET["cboQuality"];
$qualitycd   =$_GET["qualitycd"];
$quality     =$_GET["quality"];
$qualityRmrks=$_GET["qualityRmrks"];
$intStatus   =$_GET["intStatus"];

	$SQL_Check="SELECT * FROM quality where strQualityCode='$qualitycd' AND intStatus != '10'";
	$result_check = $db->RunQuery($SQL_Check);	
	
	$SQL_Check1="SELECT * FROM quality where strQuality='$quality' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	
	$SQL ="SELECT * FROM quality where intQualityId='$cboQuality' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	$SQL_Update="UPDATE quality SET  strQualityCode='$qualitycd',
		strQuality='$quality',
		intStatus='$intStatus',
		strRemarks='$qualityRmrks' 
		WHERE intQualityId='$cboQuality'"; 
	$result      =$db->ExecuteQuery($SQL_Update);
	 if($result)
	  
		echo 1;
		
	  else
	  
		echo 0;	
}
if($strButton=="DeleteData")
{		
	$cboQuality=$_GET["cboQuality"];
	$SQL = "delete from  quality  where intQualityId='$cboQuality';";
	//$db->ExecuteQuery($SQL);
	
	$result = $db->RunQuery($SQL);
	if($result)
		echo 1;
		
	  else
	  
		echo 0;		
}
?>