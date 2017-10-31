<?php
$backwardseperator = "../../";
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="URLLoadBuyerDivision")
{
$ResponseXML = "<XMLLoadBuyerDivision>";
$buyerId	  = $_GET["BuyerId"];
	$sql = "select distinct BD.intDivisionId,BD.strDivision 
		from buyerdivisions BD
		where BD.intStatus=1 ";
		if($buyerId!="")
			$sql .= " and BD.intBuyerID='$buyerId' ";
		$sql .= "order by BD.strDivision";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value=\"".""."\">".""."</option>"; 
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["intDivisionId"]."\">".$row["strDivision"]."</option>"; 
	}
$ResponseXML .= "</XMLLoadBuyerDivision>";
echo $ResponseXML;
}
?>