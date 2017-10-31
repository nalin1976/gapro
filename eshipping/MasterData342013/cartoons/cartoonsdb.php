<?php
session_start();
$userId	 	= $_SESSION["UserID"];
include("../../Connector.php");
header('Content-Type: text/xml'); 

$request 	= $_GET['request'];
$companyId  = $_SESSION["FactoryID"];
$userId	 	= $_SESSION["UserID"];

if($request=="checkcartoonAvailble")
{
	$cartoonId = $_GET["cartoonId"];
	$cartoon   = $_GET["cartoon"];
	
	$sql = "select intCartoonId from cartoon where strCartoon='$cartoon' and intCartoonId<>'$cartoonId' and intUserId=$userId";
	$result = $db->RunQuery($sql);
	$output = false;
	while($row = mysql_fetch_array($result))
	{
		$output = true;
	}
	 echo $output;	
}
if($request=="saveData")
{
	$cartoonId   = $_GET["cartoonId"];
	$length 	 = $_GET["length"];
	$width 		 = $_GET["width"];
	$height 	 = $_GET["height"];
	$cartoon 	 = $_GET["cartoon"];
	$weigtht 	 = ($_GET["weigtht"]==""?'null':$_GET["weigtht"]);
	$description = $_GET["description"];
	
	$sql_select = "select * from cartoon 
					where
					intCartoonId = $cartoonId";
	$result_select =  $db->RunQuery($sql_select);
	
	if(mysql_num_rows($result_select)==0)
	{
		$sql_insert = "insert into cartoon 
					(
					intLength, 
					intWidth, 
					intHeight, 
					strCartoon, 
					dblWeight, 
					strDescription, 
					dtmSaveDate, 
					intUserId
					)
					values
					(
					'$length', 
					'$width', 
					'$height', 
					'$cartoon', 
					 $weigtht, 
					'$description', 
					 now(), 
					'$userId'
					)";
	}
	else
	{
		$sql_insert = "update cartoon 
					set
					intLength='$length', 
					intWidth='$width', 
					intHeight='$height', 
					strCartoon='$cartoon', 
					dblWeight=$weigtht, 
					strDescription='$description', 
					dtmSaveDate=now(), 
					intUserId='$userId'
					where
					intCartoonId = $cartoonId";
	}
	$result_insert =  $db->RunQuery($sql_insert);
	if($result_insert)
		echo "saved";
	else
		echo "error";
}
if($request=="loadData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<loadCartoonData>\n";
	$cartoonId   = $_GET["cartoonId"];
	
	$sql = "select 	
				intLength, 
				intWidth, 
				intHeight, 
				strCartoon, 
				dblWeight, 
				strDescription
				from 
				cartoon
				where intCartoonId=$cartoonId";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array( $result)) 
	{
		$ResponseXML .= "<length><![CDATA[".($row["intLength"])  . "]]></length>\n";	
		$ResponseXML .= "<width><![CDATA[".($row["intWidth"])  . "]]></width>\n";
		$ResponseXML .= "<height><![CDATA[".($row["intHeight"])  . "]]></height>\n";
		$ResponseXML .= "<cartoon><![CDATA[".($row["strCartoon"])  . "]]></cartoon>\n";
		$ResponseXML .= "<weight><![CDATA[".($row["dblWeight"])  . "]]></weight>\n";	
		$ResponseXML .= "<Description><![CDATA[".($row["strDescription"])  . "]]></Description>\n";
	}
	$ResponseXML .= "</loadCartoonData>";
	echo $ResponseXML;
}

?>