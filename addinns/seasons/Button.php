<?php
include "../../Connector.php";
$strButton=trim($_GET["q"],' ');
	
if($strButton=="New")
{	
	$strSeasonCode=trim($_GET["strSeasonCode"],' ');
	$strSeason=trim($_GET["strSeason"],' ');
	$strRemarks=trim($_GET["strRemarks"],' ');
	$intStatus=$_GET["intStatus"];
	
	  $sql_insert  = "INSERT INTO seasons (strSeasonCode,strSeason,strRemarks,intStatus) values
					 ('$strSeasonCode','$strSeason','$strRemarks','$intStatus')";
	  $db->ExecuteQuery($sql_insert);		
	  echo "Saved successfully.";	
}
else if($strButton=="Save")
{  
$strSeasonID=$_GET["strSeasonID"];
$strSeasonCode=trim($_GET["strSeasonCode"],' ');
$strSeason=trim($_GET["strSeason"],' ');
$strRemarks=trim($_GET["strRemarks"],' ');
$intStatus=$_GET["intStatus"];

	$SQL_Check="SELECT * FROM seasons where strSeasonCode='$strSeasonCode' AND intStatus != '10'";
	$result_check = $db->RunQuery($SQL_Check);	
	
	$SQL_Check1="SELECT * FROM seasons where strSeason='$strSeason' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	
	$SQL ="SELECT * FROM seasons where intSeasonId='$strSeasonID' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	$SQL_Update="UPDATE seasons SET  strSeasonCode='$strSeasonCode',
		strSeason='$strSeason',
		intStatus='$intStatus',
		strRemarks='$strRemarks' 
		WHERE intSeasonId='$strSeasonID'"; 
	$db->ExecuteQuery($SQL_Update);
	echo "Updated successfully.";	
}
else if($strButton=="Delete")
{		
	$strSeasonId=$_GET["strSeasonID"];
	$SQL = "delete from  seasons  where intSeasonId='$strSeasonId';";
	//$db->ExecuteQuery($SQL);
	
	$result = $db->RunQuery2($SQL);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}
	
	echo "Deleted successfully.";
}
else if($strButton=="seasons")
{
	$SQL="SELECT * FROM seasons where intStatus <>10 order by strSeason";
	$result = $db->RunQuery($SQL);
	
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
	}  
}
?>