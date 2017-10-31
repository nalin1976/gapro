<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];

if($RequestType=="SaveSubContractorDetails")
{
	$StyleId 	=$_GET["StyleId"];
	$PartNo		=$_GET["PartNo"];
	$PartName	=$_GET["PartName"];
	$CM			=$_GET["CM"];
	$Transport	=$_GET["Transport"];	
	
	$sqlDel="delete from stylepartdetails_sub ".
			"where ".
			"intStyleId = '$StyleId' and intPartId = '$PartNo'";
	
	$db->executeQuery($sqlDel);	
		
	$sqlInsert="insert into stylepartdetails_sub ".
				"(intStyleId, ".
				"intPartId, ".
				"intPartNo, ".
				"strPartName, ".
				"dblCM, ".
				"dblTransportCost, ".
				"intStatus) ".
				"values ".
				"('$StyleId', ".
				"'$PartNo', ".
				"'$PartNo', ".
				"'$PartName', ".
				"'$CM', ".
				"'$Transport', ".
				"'1')";

	$db->executeQuery($sqlInsert);			
}
elseif($RequestType=="DeleteRow")
{
	$StyleId 	=$_GET["StyleId"];
	$PartNo 	=$_GET["PartNo"];
	
	$sqlDel="delete from stylepartdetails_sub ".
			"where ".
			"intStyleId = '$StyleId' and intPartId = '$PartNo'";
	$db->executeQuery($sqlDel);	
}
?>