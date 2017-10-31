<?php
session_start();
include "../Connector.php";
header('Content-Type: text/xml'); 
$Request=$_GET["Request"];

if($Request=="loadItem")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$styleID = $_GET["styleID"];
	$ResponseXML = "<XMLLoadItem>\n";
	
	$sql_load = "select O.intStyleId,O.strOrderNo
					from orders O
					where (O.intStatus=0 or O.intStatus=10 or O.intStatus=11)";
	if($styleID!="")
	{
		$sql_load.=" and O.strStyle='$styleID'";
	}
	$sql_load.="order by O.strOrderNo asc";
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
	$ResponseXML .= "</XMLLoadItem>\n";
	echo $ResponseXML;
}
if($Request=="loadSCNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$styleID = $_GET["styleID"];
	$ResponseXML = "<XMLLoadSCNO>\n";
	
	$sql_load = "select SP.intStyleId,SP.intSRNO
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where (O.intStatus=0 or O.intStatus=10 or O.intStatus=11) ";
	if($styleID!="")
	{
		$sql_load.="and O.strStyle='$styleID'";
	}
	$sql_load.="order by SP.intStyleId desc";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadSCNO>\n";
		echo $ResponseXML;
}
?>