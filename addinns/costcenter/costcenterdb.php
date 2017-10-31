<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Request = $_GET["Request"];
$userId	 = $_SESSION["UserID"];

if($Request=="SaveCostCenterData")
{
	$searchId = $_GET["searchId"];
	$code  	  = $_GET["code"];
	$des 	  = $_GET["des"];
	$plantId  = $_GET["plantId"];
	$FacId    = $_GET["FacId"];
	$booCheck  = checkDataAvailable($searchId);
	if($booCheck!="true")
	{
		$sql_insert = "insert into costcenters 
						(
						 strCode, 
						 strDescription, 
						 intPlantId, 
						 intFactoryId, 
						 intUserId, 
						 dtmDate
						)
						values
						(
						 '$code',
						 '$des',
						  $plantId,
						  $FacId,
						  $userId,
						  now()
						 )";
		$result_insert = $db->RunQuery($sql_insert);
		 if($result_insert)
		   echo "Saved";
		 else
		   echo "Error";
	}
	else
	{
		$sql_update = "update costcenters 
						set 
						strCode = '$code' , 
						strDescription = '$des' , 
						intPlantId = '$plantId' , 
						intFactoryId = '$FacId' , 
						intUserId = '$userId' 
						where
						intCostCenterId = '$searchId' ;";
		$result_update = $db->RunQuery($sql_update);
		 if($result_update)
		   echo "Updated";
		 else
		   echo "Error";
		 
	}
}
if($Request=="setCostData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$searchId = $_GET["searchId"];
	
	$ResponseXML = "<XMLLoadData>\n";
	
	$sql_load = "select * from costcenters where intCostCenterId='$searchId';";
	$result_load =$db->RunQuery($sql_load);
	while($row=mysql_fetch_array($result_load))
	{
		$ResponseXML .= "<strCode><![CDATA[" . $row["strCode"]  . "]]></strCode>\n";
		$ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
		$ResponseXML .= "<intPlantId><![CDATA[" . $row["intPlantId"]  . "]]></intPlantId>\n";
		$ResponseXML .= "<intFactoryId><![CDATA[" . $row["intFactoryId"]  . "]]></intFactoryId>\n";
	}
	$ResponseXML .="</XMLLoadData>"; 
	echo $ResponseXML;
	
}
if($Request=="deleteCostData")
{
	$searchId = $_GET["searchId"];
	
	$sql_delete ="delete from costcenters where intCostCenterId = '$searchId' ; ";
	$result_delete = $db->RunQuery($sql_delete);
	if($result_delete)
		echo "Deleted";
	else
		echo "Error";
}
if($Request=="setsaveData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLLoadItem>\n";
	
	$sql_load = "select intCostCenterId,strDescription from costcenters order by strDescription;";
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intCostCenterId"] ."\">".$row["strDescription"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadItem>\n";
		echo $ResponseXML;
}
function checkDataAvailable($searchId)
{
	global $db;
	$sql = "select intCostCenterId,strCode from costcenters where intCostCenterId='$searchId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	 return true;
	else
	 return false;
} 
	

?>