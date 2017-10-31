<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Request = $_GET["Request"];
$userId	 = $_SESSION["UserID"];

if($Request=="SaveCuttingValue")
{
	$factoryId  = $_GET["factoryId"];
	$cutting  	= $_GET["cutting"];
	$sewing 	= $_GET["sewing"];
	$finishing  = $_GET["finishing"];
	$packing    = $_GET["packing"];
	$booCheck   = checkDataAvailable($factoryId);
	
	if($booCheck!="true")
	{
		$sql_insert = "insert into wip_valuation 
						(
						intCompanyId, 
						dblCutting, 
						dblSewing, 
						dblFinishing, 
						dblPacking,
						intUserId, 
						dtmDate
						)
						values
						(
						$factoryId,
						$cutting,
						$sewing,
						$finishing,
						$packing,
						$userId,
						now()
						)";
		$result_insert = $db->RunQuery($sql_insert);
		if($result_insert)
		  echo "Saved";
		else
		  echo "SaveError";
	}
	else
	{
		$sql_update = "update wip_valuation 
						set
						dblCutting = '$cutting' , 
						dblSewing = '$sewing' , 
						dblFinishing = '$finishing' , 
						dblPacking = '$packing' ,
						intUserId = '$userId' , 
						dtmDate = now()
						where
						intCompanyId = '$factoryId' ;";
		$result_update = $db->RunQuery($sql_update);
		 if($result_update)
		   echo "Updated";
		 else
		   echo "UpdateError";
	}
}
if($Request=="getDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$factoryId   = $_GET["factoryId"];
	$ResponseXML = "<XMLLoadData>\n";
	
	$sql_load = "select 	 
					dblCutting, 
					dblSewing, 
					dblFinishing, 
					dblPacking 
					from 
					wip_valuation 
					where intCompanyId='$factoryId'";
					
	$result_load =$db->RunQuery($sql_load);
	if(mysql_num_rows($result_load)>0)
			$ResponseXML .= "<status><![CDATA[True]]></status>\n";
		else
			$ResponseXML .= "<status><![CDATA[False]]></status>\n";
	
	while($row=mysql_fetch_array($result_load))
	{
		$ResponseXML .= "<Cutting><![CDATA[" . $row["dblCutting"]  . "]]></Cutting>\n";
		$ResponseXML .= "<Sewing><![CDATA[" . $row["dblSewing"]  . "]]></Sewing>\n";
		$ResponseXML .= "<Finishing><![CDATA[" . $row["dblFinishing"]  . "]]></Finishing>\n";
		$ResponseXML .= "<Packing><![CDATA[" . $row["dblPacking"]  . "]]></Packing>\n";
	}
	$ResponseXML .="</XMLLoadData>"; 
	echo $ResponseXML;
}
if($Request=="deleteData")
{
	$facId = $_GET["facId"];
	
	$sql_delete = "delete from wip_valuation where intCompanyId ='$facId' ";
	$result_delete = $db->RunQuery($sql_delete);
	if($result_delete)
		echo "Deleted";
	else
		echo "DeleteError";
}
function checkDataAvailable($factoryId)
{
	global $db;
	$sql = "select intCompanyId from wip_valuation where intCompanyId='$factoryId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	 return true;
	else
	 return false;
} 
?>