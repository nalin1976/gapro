<?php
session_start();
header('Content-Type: text/xml'); 
include "../../Connector.php";
$Request 		= $_GET["Request"];

if($Request=="loadOrderNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleNo = $_GET["styleNo"];
	$ResponseXML = "<XMLLoadOrderNo>\n";
	
	$sql_load = "select SP.intStyleId,O.strOrderNo
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where (O.intStatus=0 or O.intStatus=10 or O.intStatus=11)";
					
	if($styleNo!="")
	{
		$sql_load.="and O.strStyle='$styleNo'";
	}
	$sql_load.="order by O.strOrderNo asc";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadOrderNo>\n";
		echo $ResponseXML;
}
?>