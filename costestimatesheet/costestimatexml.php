<?php
	include "../Connector.php";

header('Content-Type: text/xml'); 

$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadAllStyle")
{
	$status1 =$_GET["status1"];
	$status2 =$_GET["status2"];
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .="<LoadAllStyle>\n";
	
	$SQL="select distinct strStyle from orders O";	
	if($status1!="" && $status2!="")
	{
		$SQL.=" where O.intStatus = '$status1' OR O.intStatus = '$status2'";
	}
	$SQL.=" Order By O.strStyle";
	$result=$db->RunQuery($SQL);

		$ResponseXML .= "<option value=\"". "" ."\">"."Select One"."</option>\n";
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=\"". $row["strStyle"] ."\">".$row["strStyle"]."</option>\n";	
		}
		$ResponseXML .= "</LoadAllStyle>\n";
		echo $ResponseXML;	
}
if($RequestType=="getStyleWiseOrderNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$stytleName = $_GET["style"];
	$status1 = $_GET["status1"];
	$status2 = $_GET["status2"];
	
	$ResponseXML = "<XMLLoadItem>\n";
	$sql_load = "select SP.intStyleId,O.strOrderNo
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where O.intStyleId!='a' ";
					
	if($stytleName!="")
	{
		$sql_load.="and O.strStyle='$stytleName' ";
	}
	if($status1!="" && $status2!="" )
	{
		$sql_load.="and O.intStatus='$status1' or O.intStatus='$status2' ";
	}
	$sql_load.=" order by O.strOrderNo ";
	
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
	$stytleName = $_GET["style"];
	$status1 = $_GET["status1"];
	$status2 = $_GET["status2"];
	$ResponseXML = "<XMLLoadSCNO>\n";
	
	$sql_load = "select SP.intStyleId,SP.intSRNO
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where O.intStyleId!='a' ";
	if($stytleName!="")
	{
		$sql_load.="and O.strStyle='$stytleName' ";
	}
	if($status1!="" && $status2!="" )
	{
		$sql_load.="and O.intStatus='$status1' or O.intStatus='$status2' ";
	}
	$sql_load.="order by SP.intSRNO";
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