<?php
include "../../Connector.php";
header('Content-Type: text/xml'); 

$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadAllStyle")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML .="<LoadAllStyle>\n";

$orderStatus = $_GET["OrderStatus"];
	
	$SQL = "select distinct strStyle
			from orders O 
			INNER JOIN specification SP ON O.intStyleId=SP.intStyleId ";	
	
if($orderStatus!="")
	$SQL .= "and O.intStatus in ($orderStatus) ";
	
	$SQL .= "Order By O.strStyle";	
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["strStyle"] ."\">".$row["strStyle"]."</option>\n";	
	}
$ResponseXML .= "</LoadAllStyle>\n";
echo $ResponseXML;	
}
elseif($RequestType=="getStyleWiseOrderNo")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadItem>\n";
	
$stytleName 	= $_GET["style"];
$orderStatus 	= $_GET["OrderStatus"];
	
	$sql_load = "select SP.intStyleId,O.strOrderNo 
				from specification SP 
				INNER JOIN orders O ON O.intStyleId=SP.intStyleId ";
					
if($stytleName!="")
	$sql_load .= "and O.strStyle='$stytleName' ";

if($orderStatus!="")
	$sql_load .= "where O.intStatus in ($orderStatus) ";

	$sql_load.= "order by O.strOrderNo ";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result_load))
	{
		$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
	}
$ResponseXML .= "</XMLLoadItem>\n";
echo $ResponseXML;	
}
if($RequestType=="getStyleWiseSCNo")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadSCNO>\n";

$stytleName 	= $_GET["style"];
$orderStatus 	= $_GET["OrderStatus"];
	
	$sql_load = "select SP.intStyleId,SP.intSRNO 
				from specification SP 
				INNER JOIN orders O ON O.intStyleId=SP.intStyleId ";
if($stytleName!="")
	$sql_load .= "and O.strStyle='$stytleName' ";
	
if($orderStatus!="")
	$sql_load .= "and O.intStatus in ($orderStatus) ";
	
	$sql_load .= "order by SP.intSRNO desc";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
	while($row=mysql_fetch_array($result_load))
	{
		$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
	}
$ResponseXML .= "</XMLLoadSCNO>\n";
echo $ResponseXML;
}
?>